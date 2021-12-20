<?php
require_once('util/main.php');
require_once('util/tags.php');
require_once('model/database_apelia.php');
require_once('model/player_db.php');
require_once('model/service_db.php');
require_once('model/staff_db.php');

$lifetime = 0;  
session_set_cookie_params($lifetime, '/');
session_start();

$services = get_all_services();
$staff = get_all_staff();

include ('home.php');
 ?>
