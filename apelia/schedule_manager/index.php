<?php require_once('../model/database_apelia.php');
require_once('../model/player_db.php');
require_once('../model/service_db.php');
require_once('../model/staff_db.php');
require_once('../model/appt_db.php');
require_once('../model/fields.php');
require_once('../model/validate.php');

$lifetime = 60 * 60 * 24;  
session_set_cookie_params($lifetime, '/');
session_start();

// Set up all possible fields to validate
$validate = new Validate();
$fields = $validate->getFields();

// for the Registration page and other pages
$fields->addField('req_date', 'Date must be a Valid format.');


$user = '';
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL ){
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL && !isset($_SESSION['user']) ) {
            $action = 'login';
            }else{
             $action = 'list_services';
            }
    }           
    
switch ($action) {
    case 'login':
        include('../view/login.php');
        break;
    
    case 'list_services':
        $user = $_SESSION['user'];
        $services = get_all_services();
        $_SESSION['servid'] = '';
        include 'service_list.php';
        break;
    case 'select_service':
        $serv_id = filter_input(INPUT_POST, 'serv_id');
        $_SESSION['servid'] = $serv_id;
        $serv = get_service($serv_id);
        $trainers = get_serv_staff($serv_id);
        $periods = get_timeslots();
        $req_date = '';
        include 'book_service.php';
        break;
    case 'check_availabilty':
        $_SESSION['sid'] = '';
        $appointments = get_all_appt();
        $user = $_SESSION['user'];
        
        $req_date = filter_input(INPUT_POST, 'req_date');
        $validate->date('req_date', $req_date);
        
        $req_time = filter_input(INPUT_POST, 'req_time');      
        $slot = get_slot($req_time);
        $req_time = $slot['startTime'];
        $_SESSION['sid'] = $slot['slotID'];
        $sid = $_SESSION['sid'];
        
        $_SESSION['timeReq'] = '';
        
        //$selected_time = validate_date($req_date, $req_time);            
        if($fields->hasErrors()){ 
            $serv_id = filter_input(INPUT_POST, 'serv_id');
             $serv = get_service($serv_id);
             $periods = get_timeslots();
            include 'book_service.php';
        }else{
            $serv = get_service($_SESSION['servid']);
            $merge = new DateTime($req_date.''.$req_time);
            $request = $merge->format('h:i:s l, F d, Y ');
            
            $date = $merge->format('Y-m-d h:i:s');
            $_SESSION['timeReq'] = $date;
            $trainers = get_avail_staff($_SESSION['servid'], 
                    intval($sid), $date);
            include'select_trainer.php';
        }
        break;
    case 'confirm':
        $user = $_SESSION['user'];
        $pid = $user['playerID'];
        
        $train_id = filter_input(INPUT_POST, 'train_id');
        $tr = get_trainer($train_id);
        
        $serv_id = $_SESSION['servid'];
        $serv = get_service($serv_id);
        
        $sid = $_SESSION['sid'];
        $req = $_SESSION['timeReq'];
        add_appt($pid, $train_id, $serv_id, $sid, $req);
        $appt = get_my_appt($pid);
        include 'success.php';
        break;
    }
    
//    function validate_date($requested_date, $req_time){
//        $interval = new DateInterval('P1M');
//        $max_date = new DateTime();
//        $max_date->add($interval);
//        $max_date_f = $max_date->format('n/j/Y');
//        
//        try{
//            $req_date = new DateTime($requested_date);
//            $req_time = new DateTime($req_time);
//        } catch (Exception $ex) {
//            $error_message = "Date not in Valid Format";
//            include '../errors/error.php';
//        }
//        $req_date_f = $req_date->format('n/j/Y');
//        
//        if ($req_date_f > $max_date_f){
//            $error_message = 'Invoice Date must be less than A month from now!';
//            include '../errors/error.php';
//        }
//        
//        // Convert string to time
//        $dt1 = strtotime($req_date_f);
//        // Get day name from the date
//        $dt2 = date("l", $dt1);
//        // Convert day name to lower case
//        $dt3 = strtolower($dt2);
//          if(($dt3 == "saturday" )|| ($dt3 == "sunday"))
//          {
//              $error_message = 'Date Cannot be on a Weekend.';
//                include '../errors/error.php';
//              }else{
//                  $merge = new DateTime($req_date_f.''.
//                          $req_time->format('H:i:s'));
//                    $request = $merge->format('n/j/Y H:i:s'); // Outputs '2017-03-14 13:37:42'
//                  return $request;
//          }
//          
//    }
//    function getTimeSlots($duration, $start, $end)
//{
//    $time = array();
//    $start = new \DateTime($start);
//    $end = new \DateTime($end);
//    $start_time = $start->format('H:i:s');
//    $end_time = $end->format('H:i:s');
//    $currentTime = strtotime(Date('Y-m-d H:i:s'));
//    $i=0;
//
//    while(strtotime($start_time) <= strtotime($end_time)){
//        $start = $start_time;
//        $end = date('H:i:s',strtotime('+'.$duration.' minutes',strtotime($start_time)));
//        $start_time = date('H:i:s',strtotime('+'.$duration.' minutes',strtotime($start_time)));
//
//        $today = Date('Y-m-d');
//        $slotTime = strtotime($today.' '.$start);
//
//        if($slotTime > $currentTime){
//            if(strtotime($start_time) <= strtotime($end_time)){
//                $time[$i]['start'] = $start;
//                $time[$i]['end'] = $end;
//            }
//            $i++;
//        }
//
//    }
//    return $time;
//}

//        $duration = 120; // how much the is the duration of a time slot
//        $start    = '09:00'; // start time
//        $end      = '20:00'; // end time
?>