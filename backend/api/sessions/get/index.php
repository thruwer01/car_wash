<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/src/App/App.php";

$app = new App();
$db = $app->db;

header('Content-Type: application/json');

//Check auth
if (!isset($_SESSION['user'])) {
    return false;
    exit();
}

$sql = "SELECT * FROM `sessions` ORDER BY `time` DESC";

if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
    $sql .= " LIMIT $limit";
}

$get_last_sessions = $db->query($sql);

$sessions = [];

if ($get_last_sessions->num_rows > 0) {
    while($session = $get_last_sessions->fetch_assoc()) {
        $session_id = $session['id'];
        $client_id = $session['client_id'];
        $session_time = $session['time'];
        $session_total = 0;
        $get_session_services = $db->query("SELECT `*` FROM `services_to_sessions` WHERE `session_id` = '$session_id'");
        while ($service_connection = $get_session_services->fetch_assoc()) {
            $service_id = $service_connection['service_id'];
            $session_total += (int)$db->query("SELECT * FROM `services` WHERE `id` = '$service_id' LIMIT 1")->fetch_assoc()['price'];
        }
        $client_info = $db->query("SELECT * FROM `clients` WHERE `id` = '$client_id'")->fetch_assoc();

        $sessions[] = [
            "session_id" => $session_id,
            "client_name" => $client_info['name'],
            "client_car_number" => $client_info['car_number'],
            "total" => $session_total,
            "time" => date('d-m-Y H:i', $session_time)
        ];
    }
}

echo json_encode($sessions);