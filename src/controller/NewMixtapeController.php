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

        // NOTE TO SELF, A URI HAZ 22 chars.

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
                $mixtapeLinksValidated = array();

                // Splits the values at "newline" and throws them into a array
                $mixtapeLinks = explode("\n", $this->getPostedMixtapeLinks());
                // Arrays whos indexes contains nothing are removed
                $emptyRemoved = array_diff($mixtapeLinks, array(''));

                // Trimming away unwanted whitespaces from the links (if they exist)
                foreach ($emptyRemoved as $mixtapeLink) {
                    array_push($mixtapeLinksValidated, trim($mixtapeLink));
                }

                // Validates that the mixtape links truly are Spotify URI links
                foreach ($mixtapeLinksValidated as $mixtapeLink)
                {
                    if(strlen($mixtapeLink) != 36)
                    {
                        $this->messages->save("Mixtape contains non-Spotify URI links");
                        return $this->view->showPage();
                    }
                }

                //var_dump($mixtapeLinksValidated);
                //die;
            }
        }

        return $this->view->showPage();
    }
}