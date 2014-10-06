<?php

namespace view;

class HomeView {
    public function showPage() {
        return "<div class='jumbotron'>
      <div class='container'>
        <img src='src/gfx/Tape.png' width='200' alt='Mixtapeify' />
      </div>
    </div>

    <div class='container'>
        <h2>Hi</h2>
        <p>Content here.</p>
    </div>";
    }
}