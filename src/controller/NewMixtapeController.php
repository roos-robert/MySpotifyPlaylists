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

    // Fields to handle string dependencies
    private static $mixtapeName = "mixtapeName";
    private static $mixtapeRows = "mixtapeLinks";
    private static $mixtapeID = "mixtapeID";

    // Getters
    public function getPostedMixtapeName() {
        return $_POST[self::$mixtapeName];
    }
    public function getPostedMixtapeLinks() {
        return $_POST[self::$mixtapeRows];
    }
    public function getMixtapeID() {
        return $_GET[self::$mixtapeID];
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
                    // Checks that no more than 500 songs is trying to be added
                    if(count($emptyRemoved) > 500)
                    {
                        $this->messages->save("As of now the max amount of songs per mixtape is 500");
                        return $this->view->showPage();
                    }

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
        // If a mixtape has been chosen to be updated, it's data is collected from the DB and presented in a "update mixtape" form.
        elseif($this->view->mixtapeUpdateChosen() && !$this->view->onClickUpdateMixtape())
        {
            return $this->view->showPageUpdateMixtape($this->mixtapeRepository->getSingleMixtape($this->getMixtapeID()), $this->mixtapeRepository->getAllMixtapeRows($this->getMixtapeID()));
        }

        // If the button for updating a mixtape (from the mixtape form) has been clicked
        if($this->view->onClickUpdateMixtape())
        {
            if ($this->view->validateMixtape())
            {
                // Saving the mixtape image to server if a new image is to replace the old one
                if (!empty($_FILES['image']['name']))
                {
                    try
                    {
                        $mixtapeImagePath = $this->view->uploadMixtapeImage();
                    }
                    catch (\Exception $e)
                    {
                        $this->messages->save("Image could not be saved, is it meeting the requirements?");
                        return $this->view->showPage();
                    }
                }

                // Saving the mixtape to the database.
                try
                {
                    if (empty($_FILES['image']['name']))
                    {
                        $this->mixtapeModel = new \model\MixtapeModel($this->userModel->retriveUserID(), $this->view->getPostedMixtapeName(), $this->view->getPostedPicPath(), $this->view->getPostedMixtapeID());
                    }
                    else
                    {
                        $this->mixtapeModel = new \model\MixtapeModel($this->userModel->retriveUserID(), $this->view->getPostedMixtapeName(), $mixtapeImagePath, $this->view->getPostedMixtapeID());
                    }

                    $this->mixtapeRepository->updateMixtape($this->mixtapeModel);

                    $mixtapeLinksValidated = array();

                    // Splits the values at "newline" and throws them into a array
                    $mixtapeLinks = explode("\n", $this->getPostedMixtapeLinks());
                    // Arrays whos indexes contains nothing are removed
                    $emptyRemoved = array_diff($mixtapeLinks, array(''));
                    // Checks that no more than 500 songs is trying to be added
                    if(count($emptyRemoved) > 500)
                    {
                        $this->messages->save("As of now the max amount of songs per mixtape is 500");
                        return $this->view->showPage();
                    }

                    // Trimming away unwanted whitespaces from the links (if they exist)
                    foreach ($emptyRemoved as $mixtapeLink) {
                        array_push($mixtapeLinksValidated, trim($mixtapeLink));
                    }

                    $this->mixtapeRepository->addMixtapeRow($this->mixtapeModel->getMixtapeID(), $mixtapeLinksValidated);
                }
                catch (\Exception $e)
                {
                    $this->messages->save("Mixtape could not be saved, our database is a bit wonky at the moment!");
                    return $this->view->showPage();
                }

                return $this->view->showMixtapeAdded();
            }
            else
            {
                return $this->view->showPageUpdateMixtape($this->mixtapeRepository->getSingleMixtape($this->getMixtapeID()), $this->mixtapeRepository->getAllMixtapeRows($this->getMixtapeID()));
            }
        }
        return $this->view->showPage();
    }
}