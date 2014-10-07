<?php

namespace controller;

require_once("src/view/LoginView.php");

class LoginController {


    public function getPostedUsername() {
        return $_POST["username"];;
    }
    public function getPostedPassword() {
        return $_POST["password"];;
    }

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\LoginView();
    }

    public function checkActions() {
        return $this->view->showPage();
    }
}