<?php
namespace view;

use model\MixtapeRepository;

class MyMixtapesView {
    private $userModel;
    private $mixtapeRepository;
    private $messages;

    public function __construct()
    {
        $this->userModel = new \model\UserModel();
        $this->mixtapeRepository = new \model\MixtapeRepository();
        $this->messages = new \view\MessageView();
    }

    public function showPage() {
        if($this->userModel->getLoginStatus() === false)
        {
            header('Location: index.php');
            exit;
        }
        else
        {
            $mixtapes = $this->mixtapeRepository->getAllMixtapesForUser($this->userModel->retriveUserID());

            $content = "<div class='container'>
                            <h1>Showing your mixtapes</h1>";

            foreach ($mixtapes->toArray() as $mixtape) {
                $content .= "<h2>". $mixtape->getName() .  "</h2>";
                $content .= "<p>". $mixtape->getCreationDate() . "</p>";
                $content .= "<p><a href='?action=mixtape&mixtapeID=". $mixtape->getMixtapeID() . "'>View mixtape</a></p>";
            };

            $content .= "</div>";

                return $content;
        }
    }
}