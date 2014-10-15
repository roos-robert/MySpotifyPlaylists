<?php

namespace controller;

require_once("src/view/HomeView.php");

class HomeController {
    private $view;
    private $model;

    // Constructor, connects all the layers
    public function __construct() {
        $this->model = new \model\UserModel();
        $this->view = new \view\HomeView($this->model);
    }

    public function checkActions() {
        return $this->view->showPage();
    }
}