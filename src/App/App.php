<?php

class App {

    public $db;
    
    //Database connect information
    private $DB_HOST = "localhost", 
            $DB_USER = "u1387165_carwash", 
            $DB_PASSWORD = "carwash123", 
            $DB = "u1387165_carwash";

    function __construct() {
        $this->init();
    }

    // Array ( key => value (array) ) where key = name of page, value = array with parameters
    // Parameters of array in value:
    // [0]: Name of template (string);
    // [1]: Page title (string);
    // [2]: Access to page with login(true/false);

    private $main_config = [
        "login" => ["login.php", "CarWash - Login in system", false],
        "" => ["main.php", "CarWash - Dashboard", true],
        "services" => ["services.php", "CarWash - Services", true],
        "error" => ["error.php", NULL, false]
    ];

    private $errors_config = [
        404 => ["Page Not Found", "CarWash - Page Not Found (Error 404)"],
    ];


    private function init() {
        $this->connectDB();
    }

    private function connectDB() {
        $this->db = new \mysqli($this->DB_HOST, $this->DB_USER, $this->DB_PASSWORD, $this->DB);
    }

    private function show_template($template_name, $title = null) {
        require_once("./client/templates/$template_name");
    }

    public function view($page_name) {
        if (isset($this->main_config[$page_name]) == true) {
            if ($this->main_config[$page_name][2] == true && !isset($_SESSION['user'])) {
                header('Location: /login');
            }
            $title = $this->main_config[$page_name][1];
            $this->show_template("head.php", $title);
            $this->show_template($this->main_config[$page_name][0]);
            $this->show_template("footer.php");
        } else {
            $this->show_error(404);
        }
    }
    
    public function show_error($err_code) {
        if (isset($this->errors_config[$err_code]) == true) {
            echo $err_code;
        }
    }
}

