<?php

namespace controller;

require_once("src/view/MyMixtapesView.php");
require_once("src/view/MessageView.php");

class MyMixtapeController {

    private $view;
    private $messages;

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\MyMixtapeView();
        $this->messages = new \view\MessageView();
    }

    public function checkActions() {

        return $this->view->showPage();
    }
}