<?php

namespace controller;

require_once("src/view/HomeView.php");
require_once("src/view/AboutView.php");

class HomeController {
    private $view;
    private $model;

    // Constructor, connects all the layers
    public function __construct() {
        $this->model = new \model\UserModel();
        $this->homeView = new \view\HomeView($this->model);
        $this->aboutView = new \view\AboutView($this->model);
    }

    public function checkActions() {
        if($this->homeView->aboutChosen())
        {
            return $this->aboutView->showPage();
        }
        else
        {
            return $this->homeView->showPage();
        }
    }
}