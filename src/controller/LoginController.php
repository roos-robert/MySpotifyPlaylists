<?php

namespace controller;

require_once("src/view/LoginView.php");

class LoginController {

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\LoginView();
    }

    public function checkActions() {
        return $this->view->showPage();
    }
}