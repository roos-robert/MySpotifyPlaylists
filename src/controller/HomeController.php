<?php

namespace controller;

require_once("src/view/HomeView.php");

class HomeController {
    private $view;

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\HomeView();
    }

    public function checkActions() {
        return $this->view->showPage();
    }
}