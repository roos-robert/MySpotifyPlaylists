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
            $mixtape = $this->mixtapeRepository->getSingleMixtape($_GET["mixtapeID"]);

            if($mixtape != NULL)
            {
                if($mixtape->getUserID() == $this->userModel->retriveUserID())
                {
                    try
                    {
                        $this->mixtapeRepository->removeMixtape($_GET["mixtapeID"]);
                    }
                    catch (\Exception $e)
                    {
                        return $this->view->showPage($this->mixtapeRepository->getSingleMixtape($_GET["mixtapeID"]), $this->mixtapeRepository->getAllMixtapeRows($_GET["mixtapeID"]));
                    }

                    return $this->view->MixtapeRemoved();
                }
                else
                {
                    $this->messages->save("You cannot remove another users mixtape!");
                    return $this->view->showPage($this->mixtapeRepository->getSingleMixtape($_GET["mixtapeID"]), $this->mixtapeRepository->getAllMixtapeRows($_GET["mixtapeID"]));
                }
            }
            else
            {
                $this->messages->save("You cannot remove a mixtape that does not exist!");
                return $this->view->showPage($this->mixtapeRepository->getSingleMixtape($_GET["mixtapeID"]), $this->mixtapeRepository->getAllMixtapeRows($_GET["mixtapeID"]));
            }
        }

        $mixtapeChosen = $this->view->mixtapeChosen();

        if($mixtapeChosen != NULL)
        {
            return $this->view->showPage($this->mixtapeRepository->getSingleMixtape($mixtapeChosen), $this->mixtapeRepository->getAllMixtapeRows($mixtapeChosen));
        }
        else
        {
            return NULL;
        }
    }
}