<?php

namespace model;

require_once("./src/model/Repository.php");

class MixtapeRepository extends Repository {

    private static $userID = "UserID";
    private static $name = "Name";
    private static $picture = "Picture";
    private $user;

    public function __construct() {
        $this->dbTable = "mixtape";
        //$this->user = $user;
    }
}