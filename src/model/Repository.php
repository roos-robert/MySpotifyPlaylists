<?php

namespace model;

require_once("./Settings.php");

abstract class Repository {
    protected $dbConnection;
    protected $dbTable;
    protected $dbTableSecondary;

    protected function connection() {

        if($this->dbConnection == NULL)
        {
            $this->dbConnection = new \PDO(\Settings::$DB_CONNECTION, \Settings::$DB_USERNAME, \Settings::$DB_PASSWORD);
        }

        $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $this->dbConnection;
    }
}