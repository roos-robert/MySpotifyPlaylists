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

    // Constructor, connects all the layers.
    public function __construct() {
        $this->view = new \view\NewMixtapeView();
        $this->messages = new \view\MessageView();
    }

    public function checkActions() {
        $mixtapeImagePath = "";

        // If a new mixtape is to be added.
        if($this->view->onClickAddMixtape())
        {
            if($this->view->validateMixtape())
            {
                // Saving the mixtape image to server.
                try
                {
                    $mixtapeImagePath = $this->view->uploadMixtapeImage();
                }
                catch (\Exception $e)
                {
                    $this->messages->save("Image could not be saved, is it meeting the requirements?");
                }

                // Saving the mixtape to the database.
                try
                {

                }
                catch (\Exception $e)
                {

                }

                return $this->view->showMixtapeAdded();
            }
        }

        return $this->view->showPage();
    }
}