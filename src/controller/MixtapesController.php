<?php

namespace controller;

require_once("src/view/MixtapesView.php");
require_once("src/view/MessageView.php");
require_once("src/model/MixtapeList.php");

class MixtapesController {

    private $userModel;
    private $mixtapeRepository;
    private $view;
    private $messages;

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\MixtapesView();
        $this->messages = new \view\MessageView();
        $this->mixtapeRepository = new \model\MixtapeRepository();
        $this->userModel = new \model\UserModel();
    }

    public function checkActions() {
        return $this->view->showPage($this->mixtapeRepository->getAllMixtapes());
    }
}