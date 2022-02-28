<?php

//STATISTICS INFO:
// 1: Sessions
// 2: New Clients
// 3: Total money

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

// 1: Sessions

$start_day_time = strtotime(date('Y-m-d'));
$end_day_time = $start_day_time + 24*60*60;
$get_today_sessions = $db->query("SELECT * FROM `sessions` WHERE `time` >= '$start_day_time' AND `time` <= '$end_day_time'");

$num_sessions_today = $get_today_sessions->num_rows;

// 2: New Clients

$get_today_new_clients = $db->query("SELECT * FROM `clients` WHERE `registration_time` >= '$start_day_time' AND `registration_time` <= '$end_day_time'");

$num_new_clients_today = $get_today_new_clients->num_rows;

// 3: Total money

$total_today_earned = 0;

if ($get_today_sessions->num_rows > 0) {
    while($session = $get_today_sessions->fetch_assoc()) {
        $session_id = $session['id'];
        $session_total = 0;
        $get_session_services = $db->query("SELECT * FROM `services_to_sessions` WHERE `session_id` = '$session_id'");
        while ($service_connection = $get_session_services->fetch_assoc()) {
            $service_id = $service_connection['service_id'];
            $session_total += (int)$db->query("SELECT * FROM `services` WHERE `id` = '$service_id' LIMIT 1")->fetch_assoc()['price'];
        }
        $total_today_earned += $session_total;
    }
}

//Response 

echo json_encode([
    "date" => date("Y-m-d H:i:s"),
    "sessions" => $num_sessions_today,
    "new_clients" => $num_new_clients_today,
    "total_earned" => $total_today_earned
]);