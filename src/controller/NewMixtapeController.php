<?php

namespace controller;

require_once("src/view/NewMixtapeView.php");
require_once("src/view/MessageView.php");

class NewMixtapeController {

    private $view;
    private $messages;

    public function getPostedMixtapeName() {
        return $_POST["mixtapeName"];;
    }
    public function getPostedMixtapeLinks() {
        return $_POST["mixtapeLinks"];;
    }

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\NewMixtapeView();
        $this->messages = new \view\MessageView();
    }

    public function checkActions() {

        // NOTE TO SELF, A URI HAZ 22 chars. Can prob use explode().

        // If a user tries to login, the input is checked and validated.
        if($this->view->onClickAddMixtape())
        {
            if ($this->getPostedMixtapeName() == "")
            {
                $this->messages->save("Mixtape name is missing");
            }
            elseif ($this->getPostedMixtapeLinks() == "")
            {
                $this->messages->save("No mixtape links added, mixtape can't be empty");
            }
            else
            {

            }
        }

        return $this->view->showPage();
    }
}