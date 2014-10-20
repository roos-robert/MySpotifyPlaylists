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
            return $_GET["mixtapeID"];
        }
        else
        {
            return NULL;
        }
    }

    public function showPage($mixtape) {
        if($this->userModel->getLoginStatus() === false || !$this->mixtapeChosen())
        {
            header('Location: index.php');
            exit;
        }
        else
        {
            if($mixtape != NULL)
            {
                $content = "<div class='container'>";
                $content .= "<h1>Mixtape: " . $mixtape->getName() . "</h1>
            <p>" . $mixtape->getCreationDate() . "</p><p></p>
            <img src='src/gfx/playlistImages/" . $mixtape->getPicture() . "' width='250' />
            <h3>Songs</h3>";


                /* Dummy code right now, will use this in a foreach with the mixtape-songs to retrieve the Spotify Data
                $string = file_get_contents("http://ws.spotify.com/lookup/1/.json?uri=spotify:track:6NmXV4o6bmp704aPGyTVVG");
                $res = json_decode($string, true);
                var_dump($res["track"]["album"]["name"]);
                */


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