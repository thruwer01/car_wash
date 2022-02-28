<?php
session_start();

require_once "vendor/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/src/App/App.php";


$App = new App();
$App->view(key($_GET));


?>