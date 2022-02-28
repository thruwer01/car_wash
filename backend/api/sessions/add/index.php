<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/src/App/App.php";

header('Content-Type: application/json');

//Check auth
if (!isset($_SESSION['user']) || !isset($_POST['services'])) {
    return false;
    exit();
}

$app = new App();
$db = $app->db;

$session_services = $_POST['services'];
$time = time();

if (!isset($_POST['client_id']) || $_POST['client_id'] == "") {
    $client_name = $_POST['client_name'];
    $client_car_number = $_POST['client_car_number'];
    $db->query("INSERT INTO `clients` SET `name` = '$client_name', `car_number` = '$client_car_number', `registration_time` = '$time'");
    $client_id = $db->insert_id;
} else {
    $client_id = $_POST['client_id'];
}

$db->query("INSERT INTO `sessions` SET `client_id` = '$client_id', `time` = '$time'");
$session_id = $db->insert_id;

foreach($session_services as $service_id) {
    $db->query("INSERT INTO `services_to_sessions` SET `service_id` = '$service_id', `session_id` = '$session_id'");
}

echo json_encode([
    "status" => "success"
]);