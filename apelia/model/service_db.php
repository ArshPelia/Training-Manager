<?php
function get_all_services() {
    global $db;
    $query = 'SELECT * FROM services';
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

function get_service($serv_id) {
    global $db;
    $query = 'SELECT * FROM services
              WHERE servID = :serv_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':serv_id', $serv_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_error($e->getMessage());
    }
}

function get_serv_staff($serv_id) {
    global $db;
    $query = 'SELECT * FROM staff
              WHERE servID = :serv_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':serv_id', $serv_id);
        $statement->execute();
        $result = $statement->fetchall();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_error($e->getMessage());
    }
}

?>