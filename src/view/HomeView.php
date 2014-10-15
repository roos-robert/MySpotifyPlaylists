<?php

namespace view;

class HomeView {

    private $model;
    private $messages;

    public function __construct(\model\UserModel $model)
    {
        $this->model = $model;
        $this->messages = new \view\MessageView();
    }

    public function showPage() {
        if($this->model->getLoginStatus() === false)
        {
            return "<div class='jumbotron'>
                      <div class='container'>
                        <img src='src/gfx/Logo.png' width='500' height='200' alt='Mixtapeify' />
                      </div>
                    </div>

                    <div class='container'>
                        <h2>Welcome!</h2>
                        <p>Want to save and share Spotify playlists? You've come to the right place!</p>
                        <h3>It's easy!</h3>
                        <p>Signup, create a new playlist, add links to the songs (from Spotify) and we will do the rest for you.
                        For example, we will retrieve all the important information about the songs, as well as put your nice mixtape
                        in storage for you. So you can feel safe that you'll never loose a playlist ever again!</p>
                        <h3>Share</h3>
                        <p>We want you to share your mixtapes with others! Use all of our built-in services to make sure your friends
                        will know what great taste in music you have.</p>
                    </div>";
        }
        else
        {
            return "<div class='jumbotron'>
                      <div class='container'>
                        <img src='src/gfx/Logo.png' width='500' height='200' alt='Mixtapeify' />
                      </div>
                    </div>

                    <div class='container'>
                        <p>" . $this->messages->load() . "</p>
                        <h2>Welcome " . $this->model->retriveUsername() . "!</h2>
                        <p>Nice day for a new mixtape right? <a href=''>Create</a> a new one right now!</p>
                        <h3>Listen to mixtapes</h3>
                        <p>Or why not look at some other mixtapes submitted by our growing community? Check them out right
                         <a href=''>here</a>!</p>
                    </div>";
        }
    }
}