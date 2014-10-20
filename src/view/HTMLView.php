<?php

class HTMLView {

    private $model;

    public function __construct()
    {
        $this->model = new \model\UserModel();
    }

    public function echoHTML($body) {
        if ($body === NULL) {
            throw new \Exception("HTMLView::echoHTML does not allow body to be null");
        }
        echo "
<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta name='description' content=''>
    <meta name='author' content='Robert Roos'>
    <link rel='icon' href='./favicon.ico'>
    <title>Mixtapeify</title>
    <link href='src/css/bootstrap.min.css' rel='stylesheet'>
    <link href='src/css/style.css' rel='stylesheet'>
  </head>

  <body>

    <div class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
      <div class='container'>
        <div class='navbar-header'>
          <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='.navbar-collapse'>
            <span class='sr-only'>Toggle navigation</span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </button>
          <a class='navbar-brand' href='?'>Mixtapeify</a>
        </div>
        <div class='collapse navbar-collapse'>
          <ul class='nav navbar-nav'>";
          if ($this->model->getLoginStatus() == false)
          {
            echo "<li><a href='?action=login'>Login</a></li>
                  <li><a href='?action=signup'>Register</a></li>";
          }
          else
          {
              echo "
              <li><a href='?action=newMixtape'>New mixtape</a></li>
              <li><a href='?action=myMixtapes'>My mixtapes</a></li>
              <li><a href='?action=login&logout=true'>Logout</a></li>";
          }
             echo "
          </ul>
        </div>
      </div>
    </div>

    $body

    <div class='footer'>
      <div class='container'>
        <p class='text-muted'>&copy; Copyright 2014 - Producerad av: <a href='http://www.robertroos.eu'>RobertRoos.eu</a></p>
      </div>
    </div>

    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
    <script src='src/js/bootstrap.min.js'></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src='src/js/ie10-viewport-bug-workaround.js'></script>
  </body>
</html>
";
    }
}