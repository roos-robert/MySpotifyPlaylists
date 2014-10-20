<?php
namespace view;

class MyMixtapesView {
    private $userModel;

    private $messages;

    public function __construct()
    {
        $this->userModel = new \model\UserModel();

        $this->messages = new \view\MessageView();
    }

    public function showPage(\model\MixtapeList $mixtapes) {
        if($this->userModel->getLoginStatus() === false)
        {
            header('Location: index.php');
            exit;
        }
        else
        {
            $content = "<div class='container'>
                            <h1>Showing your mixtapes</h1>
                            <p>&nbsp;</p>

                            ";

            foreach ($mixtapes->toArray() as $mixtape) {
                $content .= "<div class='row'><div class='col-md-2'><img class='img' src='src/gfx/playlistImages/" . $mixtape->getPicture() . "' /></div>";
                $content .= "<div class='col-md-10'><h2 class='noSpacing'>". $mixtape->getName() .  "</h2>";
                $content .= "<p>". $mixtape->getCreationDate() . "</p>";
                $content .= "<p><a href='?action=mixtape&mixtapeID=". $mixtape->getMixtapeID() . "'>View mixtape</a></p></div></div><p>&nbsp;</p>";
            };

            $content .= "</div>";

                return $content;
        }
    }
}