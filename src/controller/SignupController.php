<?php

namespace controller;

require_once("src/view/SignupView.php");

class SignupController {

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\SignupView();
    }

    public function checkActions() {
        return $this->view->showPage();
    }
}