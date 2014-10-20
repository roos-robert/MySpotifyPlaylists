<?php

namespace model;

require_once("./src/model/Repository.php");
require_once("./src/model/MixtapeModel.php");
require_once("./src/model/MixtapeList.php");

class MixtapeRepository extends Repository {
    // Mixtape-table fields, note that the auto-timestamp field CreationDate is not listed here, but exists in DB.
    private static $userID = "UserID";
    private static $name = "Name";
    private static $picture = "Picture";
    private static $creationDate = "DateCreated";
    private $lastInsertedID;

    // MixtapeRow-table fields
    private static $mixtapeID = "MixtapeID"; // Exists of course in the mixtape-table above as well.
    private static $song = "Song";


    public function __construct() {
        $this->dbTable = "mixtape";
        $this->dbTableSecondary = "mixtaperow";
    }

    // Adds a new mixtape to the database. Param $picture is a string for pic-path.
    public function addMixtape(MixtapeModel $mixtape) {
        $db = $this->connection();
        $sql = "INSERT INTO $this->dbTable(" . self::$userID . ", " . self::$name . ", " . self::$picture . ") VALUES (?, ?, ?)";
        $params = array($mixtape->getUserID(), $mixtape->getName(), $mixtape->getPicture());
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
            return new \model\MixtapeModel($result[self::$userID], $result[self::$name], $result[self::$picture], $result[self::$mixtapeID], $result[self::$creationDate]);
        }
        return NULL;
    }

    public function getAllMixtapes() {
        $db = $this->connection();
        $sql = "SELECT * FROM $this->dbTable";
        $query = $db->prepare($sql);
        $query->execute();

        $mixtapeList = new \model\MixtapeList();

        foreach ($query->fetchAll() as $result) {
            $mixtapeList -> add(new \model\MixtapeModel($result[self::$userID], $result[self::$name], $result[self::$picture], $result[self::$mixtapeID], $result[self::$creationDate]));
        }

        return $mixtapeList;
    }

    public function getAllMixtapesForUser($userID) {
        $db = $this->connection();
        $sql = "SELECT * FROM $this->dbTable WHERE " . self::$userID . " = ?";
        $params = array($userID);
        $query = $db->prepare($sql);
        $query->execute($params);
        $mixtapeList = new \model\MixtapeList();

        foreach ($query->fetchAll() as $result) {
            $mixtapeList -> add(new \model\MixtapeModel($result[self::$userID], $result[self::$name], $result[self::$picture], $result[self::$mixtapeID], $result[self::$creationDate]));
        }

        return $mixtapeList;
    }
}