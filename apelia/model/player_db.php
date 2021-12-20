<?php
function get_all_players() {
    global $db;
    $query = 'SELECT * FROM players';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_player($email, $pword) {
    global $db;
    $query = 'SELECT * FROM players WHERE email = :email AND password = :pword';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':pword', $pword);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_player($fname, $lname,$phone, $email, $pword, $pos){
    global $db;
    $query = 'INSERT INTO players
                 (firstName, lastName, phone, email, password, posID, picPath)
              VALUES
                 (:fname, :lname, :phone, :email, :pword, :pos, null)';
    try{
    $statement = $db->prepare($query);
    $statement->bindValue(':fname', $fname);
    $statement->bindValue(':lname', $lname);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':pword', $pword);
    $statement->bindValue(':pos', $pos);
    $statement->execute();
    $statement->closeCursor();
    
    $player_id = $db->lastInsertId();
        return $player_id;
        
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
}
        }
        

    function update_player($pid, $fName, $lName, $phone, $email, $pass, $pos) {
        global $db;
        if ($pid != '') {
        $query = 'UPDATE players SET 
        firstName = :fName, lastName = :lName, phone = :phone, email = :email,
        password = :pass, posID = :pos where playerID = :pid';
        try{
        $statement = $db->prepare($query);
        $statement->bindValue(':pid', $pid);
        $statement->bindValue(':fName', $fName);
        $statement->bindValue(':lName', $lName);
        $statement->bindValue(':phone', $phone);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':pass', $pass);
        $statement->bindValue(':pos', $pos);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
        } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);}
        }else{
            add_player($fName, $lName, $phone, $email, $pass, $pos);  
        }
    }
    
    function get_all_positions(){
        global $db;
    $query = 'SELECT * FROM positions';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }        
}

function get_pos_byNane($posname){
        global $db;
    $query = 'SELECT * FROM positions where positionName = :posname';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':posname', $posname);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }        
}

function update_profile_pic($picPath, $pid){
    global $db;
    $query = 'UPDATE players SET picPath = :picPath where playerID = :pid';
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(':pid', $pid);
        $statement->bindValue(':picPath', $picPath);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        
        }
}
