<?php

namespace controller;

require_once("src/view/SignupView.php");
require_once("src/view/MessageView.php");
require_once("src/model/UserModel.php");
require_once("src/model/UserRepository.php");

class SignupController {

    private $model;
    private $userRepository;
    private $view;
    private $messages;

    // Constructor, connects all the layers
    public function __construct() {
        $this->model = new \model\UserModel();
        $this->userRepository = new \model\UserRepository();
        $this->view = new \view\SignupView($this->model);
        $this->messages = new \view\MessageView();
    }

    public function checkActions() {

        // If a user tries to login, the input is checked and validated.
        if($this->view->onClickRegister())
        {
            if($this->view->validateUser())
            {
                $this->userRepository->add($this->view->getPostedUsername(), $this->view->getPostedPassword(), $this->view->getPostedEmail());
                return $this->view->showSignupMessage();
            }
            else
            {
                return $this->view->showPage();
            }
        }
        else
        {
            return $this->view->showPage();
        }
    }
}