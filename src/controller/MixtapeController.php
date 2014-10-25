<?php

namespace controller;

require_once("src/view/MixtapeView.php");
require_once("src/view/MessageView.php");
require_once("src/model/MixtapeList.php");

class MixtapeController {
    private $userModel;
    private $mixtapeRepository;
    private $view;
    private $messages;

    // Fields to handle string dependencies
    private static $mixtapeID = "mixtapeID";

    // Getters
    public function getMixtapeID() {
        return $_GET[self::$mixtapeID];
    }

    // Constructor, connects all the layers
    public function __construct() {
        $this->view = new \view\MixtapeView();
        $this->messages = new \view\MessageView();
        $this->mixtapeRepository = new \model\MixtapeRepository();
        $this->userModel = new \model\UserModel();
    }

    public function checkActions() {

        // If a user want's to remove one of his own mixtapes.
        if($this->view->mixtapeRemoveChosen())
        {
            $mixtape = $this->mixtapeRepository->getSingleMixtape($this->getMixtapeID());

            // If the mixtape that is to be removed exists, then.
            if($mixtape != NULL)
            {
                // Checks that the user trying to remove the mixtape is the creator.
                if($mixtape->getUserID() == $this->userModel->retriveUserID())
                {
                    try
                    {
                        $this->mixtapeRepository->removeMixtape($this->getMixtapeID());
                    }
                    catch (\Exception $e)
                    {
                        return $this->view->showPage($this->mixtapeRepository->getSingleMixtape($this->getMixtapeID()), $this->mixtapeRepository->getAllMixtapeRows($this->getMixtapeID()));
                    }

                    return $this->view->MixtapeRemoved();
                }
                else
                {
                    $this->messages->save("You cannot remove another users mixtape!");
                    return $this->view->showPage($this->mixtapeRepository->getSingleMixtape($this->getMixtapeID()), $this->mixtapeRepository->getAllMixtapeRows($this->getMixtapeID()));
                }
            }
            else
            {
                $this->messages->save("You cannot remove a mixtape that does not exist!");
                return $this->view->showPage($this->mixtapeRepository->getSingleMixtape($this->getMixtapeID()), $this->mixtapeRepository->getAllMixtapeRows($this->getMixtapeID()));
            }
        }
        // If a mixtape is chosen, it will be fetched from the database and presented to the User.
        elseif($this->view->mixtapeChosen())
        {
            return $this->view->showPage($this->mixtapeRepository->getSingleMixtape($this->getMixtapeID()), $this->mixtapeRepository->getAllMixtapeRows($this->getMixtapeID()));
        }
        else
        {
            return NULL;
        }
    }
}