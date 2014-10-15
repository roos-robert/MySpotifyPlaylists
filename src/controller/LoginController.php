<?php

namespace controller;

require_once("src/view/LoginView.php");
require_once("src/model/UserModel.php");

class LoginController {
    private $model;
    private $view;

    public function getPostedUsername() {
        return $_POST["username"];;
    }
    public function getPostedPassword() {
        return $_POST["password"];;
    }

    // Constructor, connects all the layers
    public function __construct() {
        $this->model = new \model\UserModel();
        $this->view = new \view\LoginView($this->model);
    }

    public function checkActions() {
        return $this->view->showPage();
    }
}