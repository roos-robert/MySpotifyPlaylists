<?php

namespace controller;

require_once("src/view/MyMixtapesView.php");
require_once("src/view/MessageView.php");
require_once("src/model/MixtapeList.php");

class MyMixtapesController {

    private $userModel;
    private $mixtapeRepository;
    private $view;
    private $messages;

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\MyMixtapesView();
        $this->messages = new \view\MessageView();
        $this->mixtapeRepository = new \model\MixtapeRepository();
        $this->userModel = new \model\UserModel();
    }

    public function checkActions() {

        return $this->view->showPage($this->mixtapeRepository->getAllMixtapesForUser($this->userModel->retriveUserID()));
    }
}