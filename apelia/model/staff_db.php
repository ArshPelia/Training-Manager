<?php
function get_all_staff() {
    global $db;
    $query = 'SELECT * FROM staff ORDER BY servID';
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

function get_trainer($train_id) {
    global $db;
    $query = 'SELECT * FROM staff
              WHERE staffID = :train_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':train_id', $train_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_error($e->getMessage());
    }
}

?>