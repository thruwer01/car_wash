<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/src/App/App.php";

$app = new App();
$db = $app->db;

header('Content-Type: application/json');

$car_number = $_POST['car_number'];

//Check auth
if (!isset($_SESSION['user']) || !isset($_POST['car_number'])) {
    return false;
    exit();
}

$get_client_by_car_number = $db->query("SELECT * FROM `clients` WHERE `car_number` = '$car_number'");

if ($get_client_by_car_number->num_rows !== 0) {
    echo json_encode([
        "status" => "success",
        "client" => $get_client_by_car_number->fetch_assoc()
    ]);
} else {
    echo json_encode([
        "status" => "error"
    ]);
}