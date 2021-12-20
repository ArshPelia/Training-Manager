<?php
function get_all_appt() {
    global $db;
    $query = 'SELECT * FROM appointments';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_error($e->getMessage());
    }
}

function get_my_appt($pid) {
    global $db;
    $query = 'SELECT * FROM appointments where playerID = :pid';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':pid', $pid);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_error($e->getMessage());
    }
}


function get_timeslots() {
    global $db;
    $query = 'SELECT * FROM timeslots';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_error($e->getMessage());
    }
}


function get_slot($req_slot) {
    global $db;
    $query = 'SELECT * FROM timeslots where slotID = :req_slot';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':req_slot', $req_slot);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_error($e->getMessage());
    }
}

function get_slot_id($req_slot) {
    global $db;
    $query = 'SELECT slotID FROM timeslots where slotID = :req_slot';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':req_slot', $req_slot);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_error($e->getMessage());
    }
}

function check_slot_avail($slotID, $staffID, $request){
    global $db;
    $query = 'SELECT * FROM appointments where slotID = :slotID AND stafID = :staffID'
            . 'AND apptDate = :request';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':slotID', $slotID);
        $statement->bindValue(':staffID', $staffID);
        $statement->bindValue(':request', $request);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_error($e->getMessage());
    }
}   

function get_avail_staff($servID, $slotID, $apptDate){
    global $db; 
       $query =     'SELECT * FROM staff where servID = :servID and staffID NOT IN
            (SELECT staffID FROM appointments where slotID = :slotID and 
            apptDate = :apptDate)'; 
//       SELECT * FROM staff left JOIN appointments ON appointments.staffID = staff.staffID
//where appointments.slotID != 1 AND appointments.apptDate != '04/15/2021 09:00:00' AND
//appointments.servID = 'T'
   try{
    $statement = $db->prepare($query);
        $statement->bindValue(':servID', $servID);
        $statement->bindValue(':slotID', $slotID);
        $statement->bindValue(':apptDate', $apptDate);
        $statement->execute();
        $result = $statement->fetchall();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_error($e->getMessage());
    }
}

function add_appt($pid, $train_id, $servID, $slotID, $apptDate){  
global $db;
    $query = 'INSERT INTO appointments
                 (playerID, staffID, servID, slotID, apptDate, completed )
              VALUES
                 (:pid, :train_id, :servID, :slotID, :apptDate, 0)';
    try{
    $statement = $db->prepare($query);
    $statement->bindValue(':pid', $pid);
    $statement->bindValue(':train_id', $train_id);
    $statement->bindValue(':servID', $servID);
    $statement->bindValue(':slotID', $slotID);
    $statement->bindValue(':apptDate', $apptDate);
    $statement->execute();
    $statement->closeCursor();
    
    $appt_id = $db->lastInsertId();
        return $appt_id;
        
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
}
        }
    
?>