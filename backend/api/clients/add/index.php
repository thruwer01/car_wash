<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/src/App/App.php";

header('Content-Type: application/json');

$app = new App();
$db = $app->db;
$time = time();
$car_number = "1232131";//$_POST['car_number'];
$sql = "INSERT INTO `clients` SET `car_number` = '$car_number'";

//Check auth
if (!isset($_SESSION['user']) || !isset($_POST['car_number'])) {
    return false;
    exit();
}

//add in database
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $sql .= ", `name` = '$name'";
}

$sql .= ", `registration_time` = '$time'";
$db->query($sql);

print_r($db);




