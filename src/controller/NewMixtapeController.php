<?php

namespace controller;

require_once("src/view/NewMixtapeView.php");

class NewMixtapeController {

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\NewMixtapeView();
    }

    public function checkActions() {

        // NOTE TO SELF, A URI HAZ 22 chars. Can prob use explode().

        return $this->view->showPage();
    }
}