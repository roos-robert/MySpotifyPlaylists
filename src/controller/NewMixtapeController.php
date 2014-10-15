<?php

namespace controller;

require_once("src/view/NewMixtapeView.php");

class NewMixtapeController {

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\NewMixtapeView();
    }

    public function checkActions() {
        return $this->view->showPage();
    }
}