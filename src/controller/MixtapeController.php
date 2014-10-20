<?php

namespace controller;

require_once("src/view/MixtapeView.php");
require_once("src/view/MessageView.php");
require_once("src/model/MixtapeList.php");

class MyMixtapeController {

    private $userModel;
    private $mixtapeRepository;
    private $view;
    private $messages;

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\MixtapeView();
        $this->messages = new \view\MessageView();
        $this->mixtapeRepository = new \model\MixtapeRepository();
        $this->userModel = new \model\UserModel();
    }

    public function checkActions() {
        if($this->view->mixtapeChosen() != NULL)
        {
            return $this->view->showPage($this->mixtapeRepository->getSingleMixtape($this->view->mixtapeChosen()));
        }
        else
        {
            return NULL;
        }
    }
}