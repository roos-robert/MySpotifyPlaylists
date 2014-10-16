<?php

namespace model;

require_once("./src/model/Repository.php");

class MixtapeRepository extends Repository {

    // Mixtape-table fields, note that the auto-timestamp field CreationDate is not listed here, but exists in DB.
    private static $userID = "UserID";
    private static $name = "Name";
    private static $picture = "Picture";
    private $lastInsertedID;

    // MixtapeRow-table fields
    private static $mixtapeID = "MixtapeID";
    private static $song = "Song";


    public function __construct() {
        $this->dbTable = "mixtape";
        $this->dbTableSecondary = "mixtaperow";
    }

    // Adds a new mixtape to the database. Param $picture is a string for pic-path.
    public function addMixtape($userID, $name, $picture) {
        $db = $this->connection();
        $sql = "INSERT INTO $this->dbTable(" . self::$userID . ", " . self::$name . ", " . self::$picture . ") VALUES (?, ?, ?)";
        $params = array($userID, $name, $picture);
        $query = $db->prepare($sql);
        $query->execute($params);

        return $db->lastInsertId();
    }

    // Adds rows (songs) to the by mixtapeID specified mixtape. Param $songs is an array.
    public function addMixtapeRow($mixtapeID, $songs) {



        foreach ($songs as $song)
        {
            $db = $this->connection();
            $sql = "INSERT INTO $this->dbTable(" . self::$mixtapeID . ", " . self::$song . ") VALUES (?, ?)";
            $params = array($mixtapeID, $song);
            $query = $db->prepare($sql);
            $query->execute($params);
        }
    }
}