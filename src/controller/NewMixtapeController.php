<?php

namespace controller;

require_once("src/view/NewMixtapeView.php");
require_once("src/view/MessageView.php");
require_once("src/model/MixtapeRepository.php");
require_once("src/model/UserModel.php");
require_once("src/model/MixtapeModel.php");

class NewMixtapeController {

    private $view;
    private $messages;
    private $userModel;
    private $mixtapeModel;
    private $mixtapeRepository;

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
        $this->userModel = new \model\UserModel();
        $this->mixtapeRepository = new \model\MixtapeRepository();
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
                    return $this->view->showPage();
                }

                // Saving the mixtape to the database.
                try
                {
                    $this->mixtapeModel = new \model\MixtapeModel($this->userModel->retriveUserID(), $this->getPostedMixtapeName(), $mixtapeImagePath);
                    $mixtapeID = $this->mixtapeRepository->addMixtape($this->mixtapeModel);

                    $mixtapeLinksValidated = array();

                    // Splits the values at "newline" and throws them into a array
                    $mixtapeLinks = explode("\n", $this->getPostedMixtapeLinks());
                    // Arrays whos indexes contains nothing are removed
                    $emptyRemoved = array_diff($mixtapeLinks, array(''));

                    // Trimming away unwanted whitespaces from the links (if they exist)
                    foreach ($emptyRemoved as $mixtapeLink) {
                        array_push($mixtapeLinksValidated, trim($mixtapeLink));
                    }

                    $this->mixtapeRepository->addMixtapeRow($mixtapeID, $mixtapeLinksValidated);
                }
                catch (\Exception $e)
                {
                    $this->messages->save("Mixtape could not be saved, our database is a bit wonky at the moment!");
                    return $this->view->showPage();
                }

                return $this->view->showMixtapeAdded();
            }
        }
        elseif($this->view->mixtapeUpdateChosen())
        {
            return $this->view->showPageUpdateMixtape();
        }

        return $this->view->showPage();
    }
}