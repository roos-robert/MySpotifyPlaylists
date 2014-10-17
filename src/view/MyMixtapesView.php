<?php
namespace view;

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
            $mixtape = $this->mixtapeRepository->getSingleMixtape(25);

            $content = "<div class='container'>
                            <h1>Showing your mixtapes</h1>";
            $content .= $mixtape->getName();
            $content .= "</div>";

                return $content;
        }
    }
}