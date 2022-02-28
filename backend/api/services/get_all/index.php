<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/src/App/App.php";

header('Content-Type: application/json');

//Check auth
if (!isset($_SESSION['user'])) {
    return false;
    exit();
}

$app = new App();
$db = $app->db;
$services = [];

$get_services = $db->query("SELECT * FROM `services`");

if ($get_services->num_rows > 0) {
    while($service = $get_services->fetch_assoc()) {
        $services[] = $service;
    }
}

echo json_encode([
    "status" => "success",
    "data" => $services
]);