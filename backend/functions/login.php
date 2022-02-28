<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/src/App/App.php";

$app = new App();
$db = $app->db;

$login = $_POST["login"];
$pass = $_POST["password"];

$find_user = $db->query("SELECT * FROM `users` WHERE `login` = '$login'");

if ($find_user->num_rows == 0) {
    echo "User not found";
    return;
}

if ($find_user->num_rows == 1) {
    $user = $find_user->fetch_assoc();
    $user_password_hash = $user['password_hash'];
}

if (password_verify($pass, $user_password_hash)) {
    // echo "Password verified";
    $_SESSION['user'] = $user['login'];
    header('Location: /');
} else {
    echo "Password not verified";
}