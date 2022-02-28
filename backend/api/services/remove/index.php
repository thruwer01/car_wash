<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/src/App/App.php";

header('Content-Type: application/json');

//Check auth
if (!isset($_SESSION['user']) || !isset($_POST['session_id'])) {
    return false;
    exit();
}

$app = new App();
$db = $app->db;

$session_id = $_POST['session_id'];

$get_services = $db->query("DELETE FROM `services` WHERE `id` = '$session_id'");

echo json_encode([
    "status" => "success"
]);