<?php

namespace view;

class AboutView {
    private $model;
    private $messages;

    public function __construct(\model\UserModel $model)
    {
        $this->model = $model;
        $this->messages = new \view\MessageView();
    }

    public function showPage() {
        return "<div class='jumbotron'>
                  <div class='container'>
                    <img src='src/gfx/Logo.png' width='500' height='200' alt='Mixtapeify' />
                  </div>
                </div>

                <div class='container'>
                    <p>" . $this->messages->load() . "</p>
                    <h2>About Mixtapeify</h2>
                    <p>Mixtapeify is a online backup service for all your Spotify playlists.</p>
                    <p>We are here to make sure that even if you by accident delete one of your playlists in the Spotify client
                    instantly can come here and look up the exact songs you had in that playlist, to build it up agan</p>
                    <h3>How do I use it?</h3>
                    <p>It's simple! Here is how you add a new mixtape to your collection.</p>
                    <p><iframe width='640' height='360' src='//www.youtube.com/embed/Gd9W2Ukzi5g?rel=0' frameborder='0' allowfullscreen></iframe></p>
                    <p>&nbsp;</p>
                </div>";
    }
}