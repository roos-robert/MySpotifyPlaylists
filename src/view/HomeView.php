<?php

namespace view;

class HomeView {
    public function showPage() {
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
}