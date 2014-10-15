<?php

namespace view;
class MessageView {
    private $message = "message";
    // Function for saving a message to the session.
    public function save($string) {
        $_SESSION[$this->message] = $string;
    }
    
    // Function for retrieving the message, present it, and delete it.
    public function load() {
        if(isset($_SESSION[$this->message]))
        {
            $ret = $_SESSION[$this->message];
        }
        else
        {
            $ret = "";
        }
        $_SESSION[$this->message] = "";
        return $ret;
    }
}