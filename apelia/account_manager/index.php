<?php  
$lifetime = 60 * 60 * 24;  
session_set_cookie_params($lifetime, '/');
session_start();
require_once('../model/database_apelia.php');
require_once('../model/player_db.php');
require_once('../model/fields.php');
require_once('../model/validate.php');
require_once('../model/appt_db.php');
require_once('../model/service_db.php');
require_once '../util/file_util.php';
require_once '../util/image_util.php';

$validate = new Validate();
$fields = $validate->getFields();
$fields->addField('fname');
$fields->addField('lname');
$fields->addField('phone', 'Use 999-999-9999 format.');
$fields->addField('email', 'Must be a valid email address.');
$fields->addField('pword', 'Must be at least 8 characters.');
$fields->addField('verify', "Passwords Must Match");

$image_dir = '../resources/images/profileimages/';
$image_dir_path = getcwd() . DIRECTORY_SEPARATOR . $image_dir;

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
            $action = 'login';}
    }

switch ($action) {
    case 'login':
        if (!empty($_SESSION['user'])){
            $user = $_SESSION['user'];
            $pid = $user['playerID'];
            $appt = get_my_appt($pid);
            $positions = get_all_positions();
            include 'view_account.php';
        } else {
        include('../view/login.php');
        }
        break;
        
    case 'register_form':
        $fname = '';
        $lname = '';
        $verify = '';
        $phone = '';
        $email = '';
        $pword = '';
        $positions = get_all_positions();
        include('register.php');
        break;
    
    case 'signin':
        $email = filter_input(INPUT_POST, 'email');
        $_SESSION['user'] = get_player($email, filter_input(INPUT_POST, 'pword'));
        if ($_SESSION['user'] != null){
            $user = $_SESSION['user'];
            $pid = $user['playerID'];
            $appt = get_my_appt($pid);
            $positions = get_all_positions();
            include('view_account.php');     
        } else {
            $_SESSION['user'] = '';
            $error_message = 'Error. Email or Password is incorrect. Try Again.';
            display_db_error($error_message);
        }
        break;
        
    case 'register':
        $fname = filter_input(INPUT_POST, 'fname');
        $lname = filter_input(INPUT_POST, 'lname'); 
        $email = filter_input(INPUT_POST, 'email');
        $phone = filter_input(INPUT_POST, 'phone'); 
        $pword = filter_input(INPUT_POST, 'pword');
        $verify = filter_input(INPUT_POST, 'verify');
        $posname = filter_input(INPUT_POST, 'pos');
        $pos = get_pos_byNane($posname);
        $pos_id = $pos['posID'];
        $validate->email('email', $email);
        $validate->pword('pword', $pword);
        $validate->verify('verify', $pword, $verify);
        $validate->text('fname', $fname);
        $validate->text('lname', $lname);
        $validate->phone('phone', $phone);
        if ($fields->hasErrors()) {
            $positions = get_all_positions();
            include ('register.php');
        }else{
        add_player($fname, $lname, $phone, $email, $pword, $pos_id);
        include ('reg_success.php');}
        break;
    
    case 'account_form':
        $fname = '';
        $lname = '';
        $verify = '';
        $phone = '';
        $email = '';
        $pword = '';
        $user = $_SESSION['user'];
        $pid = $user['playerID'];
        $appt = get_my_appt($pid);
        if($appt === NULL){
            $appt = array();
        }
        include('view_account.php'); 
        break;
    
    case 'logout':
        unset($_SESSION['user']);
        $_SESSION = array();
        session_destroy();
        $name = session_name();
        $expire = strtotime('-1 year');
        $params = session_get_cookie_params();
        $path = $params['path'];
        $domain = $params['domain'];
        $secure = $params['secure'];
        $httponly = $params['httponly'];
        setcookie($name, '', $expire, $path, $domain, $secure, $httponly);
        include '../view/logged_out.php';
        break;
    
    case 'update':
        $fname = filter_input(INPUT_POST, 'fname');
        $lname = filter_input(INPUT_POST, 'lname'); 
        $email = filter_input(INPUT_POST, 'email');
        $phone = filter_input(INPUT_POST, 'phone'); 
        $pword = filter_input(INPUT_POST, 'pword');
        $verify = filter_input(INPUT_POST, 'verify');
        $posname = filter_input(INPUT_POST, 'pos');
        $pos = get_pos_byNane($posname);
        $pos_id = $pos['posID'];
        $validate->email('email', $email);
        $validate->pword('pword', $pword);
        $validate->verify('verify', $pword, $verify);
        $validate->text('fname', $fname);
        $validate->text('lname', $lname);
        $validate->phone('phone', $phone);
       
        if ($fields->hasErrors()) { 
            $user = $_SESSION['user'];
            $pid = $user['playerID'];
            $appt = get_my_appt($pid);
            if($appt === NULL){
            $appt = array();}
        $positions = get_all_positions();
            include('view_account.php'); 
        } else {
            $user = $_SESSION['user'];
            $pid = $user['playerID'];
            update_player($pid, $fname, $lname, $phone, $email, $pword, $pos_id);
            $user = get_player($email, $pword);
            $_SESSION['user'] = $user;
            include('update_success.php'); 
        }
        break;       
    case 'upload':
        $pic = 'file1';
        $fileName = $_FILES['file1']['name'];
        $filePath = $image_dir. $fileName;
        $user = $_SESSION['user'];
        $pid = $user['playerID'];
        update_profile_pic($filePath, $pid);
        $user = get_player($_SESSION['user']['email'], $_SESSION['user']['password']);
        $_SESSION['user'] = $user;
        upload_pic('file1');
        $appt = get_my_appt($pid);
            if($appt === NULL){
            $appt = array();}
        include('view_account.php');
        break;       
}


function upload_pic($name){
    global $image_dir_path;
    if(isset($_FILES[$name])){
        $filename = $_FILES[$name]['name'];
        if(empty($filename)){
            return;
        }
        $source = $_FILES[$name]['tmp_name'];
        $target = $image_dir_path . DIRECTORY_SEPARATOR . $filename;
        move_uploaded_file($source, $target);

        // create the '400' and '100' versions of the image
        process_image($image_dir_path, $filename);
    }
}

?>