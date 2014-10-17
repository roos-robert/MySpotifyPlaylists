<?php

namespace view;

class MixtapeView {
    private $userModel;
    private $mixtapeRepository;
    private $messages;

    public function __construct()
    {
        $this->userModel = new \model\UserModel();
        $this->mixtapeRepository = new \model\MixtapeRepository();
        $this->messages = new \view\MessageView();
    }

    public function mixtapeChosen() {
        if (isset($_GET["mixtapeID"]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function showPage() {
        if($this->userModel->getLoginStatus() === false || !$this->mixtapeChosen())
        {
            header('Location: index.php');
            exit;
        }
        else
        {
            $mixtape = $this->mixtapeRepository->getSingleMixtape($_GET["mixtapeID"]);

            if($mixtape != NULL)
            {
                $content = "<div class='container'>";
                $content .= "<h1>Mixtape: " . $mixtape->getName() . "</h1>
            <p>" . $mixtape->getCreationDate() . "</p><p></p>
            <img src='src/gfx/playlistImages/" . $mixtape->getPicture() . "' width='250' />
            <h3>Songs</h3>";
                $content .= "</div>";

                return $content;
            }
            else
            {
                return "<div class='container'>
                <h1>Not found</h1>
                <p>No mixtape with that ID was found</p>
                </div>";
            }

        }
    }
}