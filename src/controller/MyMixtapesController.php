<?php

namespace controller;

require_once("src/view/MyMixtapesView.php");
require_once("src/view/MessageView.php");

class MyMixtapesController {

    private $view;
    private $messages;

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\MyMixtapesView();
        $this->messages = new \view\MessageView();
    }

    public function checkActions() {

        return $this->view->showPage();
    }
}