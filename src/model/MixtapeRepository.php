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
    private static $mixtapeID = "MixtapeID"; // Exists of course in the mixtape-table above as well.
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
        $db = $this->connection();
        $sql = "INSERT INTO $this->dbTableSecondary(" . self::$mixtapeID . ", " . self::$song . ") VALUES (?, ?)";
        foreach ($songs as $song)
        {
            $params = array($mixtapeID, $song);
            $query = $db->prepare($sql);
            $query->execute($params);
        }
    }

    public function getSingleMixtape($mixtapeID) {
        $db = $this->connection();
        $sql = "SELECT * FROM $this->dbTable WHERE " . self::$mixtapeID . " = ?";
        $params = array($mixtapeID);
        $query = $db->prepare($sql);
        $query->execute($params);
        $result = $query->fetch();
        if($result)
        {
            return $result;
        }
        return NULL;
    }

    public function getAllMixtapes() {
        $db = $this->connection();
        $sql = "SELECT * FROM $this->dbTable";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetch();
        if($result)
        {
            return $result;
        }
        return NULL;
    }

    public function getAllMixtapesForUser($userID) {
        $db = $this->connection();
        $sql = "SELECT * FROM $this->dbTable WHERE " . self::$userID . " = ?";
        $params = array($userID);
        $query = $db->prepare($sql);
        $query->execute($params);
        $result = $query->fetch();
        if($result)
        {
            return $result;
        }
        return NULL;
    }
}