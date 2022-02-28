<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/src/App/App.php";

header('Content-Type: application/json');

//Check auth
if (!isset($_SESSION['user']) || !isset($_POST['title']) || !isset($_POST['time']) || !isset($_POST['price'])) {
    return false;
    exit();
}

$title = $_POST['title'];
$time = $_POST['time'];
$price = $_POST['price'];

$app = new App();
$db = $app->db;

$db->query("INSERT INTO `services` SET `title` = '$title', `price` = '$price', `time` = '$time'");

echo json_encode([
    "status" => "success"
]);