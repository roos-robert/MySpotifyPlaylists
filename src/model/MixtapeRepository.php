<?php

namespace model;

require_once("./src/model/Repository.php");
require_once("./src/model/MixtapeModel.php");
require_once("./src/model/MixtapeRowModel.php");
require_once("./src/model/MixtapeList.php");
require_once("./src/model/MixtapeRowList.php");

class MixtapeRepository extends Repository {
    // Mixtape-table fields
    private static $userID = "UserID";
    private static $name = "Name";
    private static $picture = "Picture";
    private static $creationDate = "DateCreated";

    // MixtapeRow-table fields
    private static $mixtapeRowID = "MixtapeRowID";
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

    // Gets the requested mixtape from the database, returns a MixtapeModel object.
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

    // Retrieves all the mixtapes in the database, returns a MixtapeList populated with MixtapeModel objects.
    public function getAllMixtapes() {
        $db = $this->connection();
        $sql = "SELECT * FROM $this->dbTable ORDER BY " . self::$creationDate . " DESC";
        $query = $db->prepare($sql);
        $query->execute();

        $mixtapeList = new \model\MixtapeList();

        foreach ($query->fetchAll() as $result) {
            $mixtapeList -> add(new \model\MixtapeModel($result[self::$userID], $result[self::$name], $result[self::$picture], $result[self::$mixtapeID], $result[self::$creationDate]));
        }

        return $mixtapeList;
    }

    // Retrieves all the mixtape rows for a given mixtape, returns a MixtapeRowList populated with MixtapeRow objects.
    public function getAllMixtapeRows($mixtapeID) {
        $db = $this->connection();
        $sql = "SELECT * FROM $this->dbTableSecondary WHERE " . self::$mixtapeID . " = ? ORDER BY " . self::$mixtapeRowID . " ASC";
        $params = array($mixtapeID);
        $query = $db->prepare($sql);
        $query->execute($params);
        $mixtapeRowList = new \model\MixtapeRowList();

        foreach ($query->fetchAll() as $result) {
            $mixtapeRowList -> add(new \model\MixtapeRowModel($result[self::$mixtapeID], $result[self::$song]));
        }

        return $mixtapeRowList;
    }

    // Retrives all mixtapes for the given user, returns a MixtapeList containting MixtapeModel objects.
    public function getAllMixtapesForUser($userID) {
        $db = $this->connection();
        $sql = "SELECT * FROM $this->dbTable WHERE " . self::$userID . " = ? ORDER BY " . self::$creationDate . " DESC";
        $params = array($userID);
        $query = $db->prepare($sql);
        $query->execute($params);
        $mixtapeList = new \model\MixtapeList();

        foreach ($query->fetchAll() as $result) {
            $mixtapeList -> add(new \model\MixtapeModel($result[self::$userID], $result[self::$name], $result[self::$picture], $result[self::$mixtapeID], $result[self::$creationDate]));
        }

        return $mixtapeList;
    }

    // Updates a existing mixtape in the database, and to be noted is that when a mixtape is updated. All it's MixtapesRows are deleted
    // and then replaced by new rows. This is intentional, since it's highly likley that the user pastes updates directly from Spotify
    // checking changes row for row is therefor useless.
    public function updateMixtape(MixtapeModel $mixtape) {
        $db = $this->connection();
        $sql = "UPDATE $this->dbTable SET " . self::$userID . "=?," . self::$name . "=?," . self::$picture . "=? WHERE " . self::$mixtapeID . "=?";
        $params = array($mixtape->getUserID(), $mixtape->getName(), $mixtape->getPicture(), $mixtape->getMixtapeID());
        $query = $db->prepare($sql);
        $query->execute($params);

        $db = $this -> connection();
        $sql = "DELETE FROM $this->dbTableSecondary WHERE " . self::$mixtapeID . " = ?";
        $params = array($mixtape->getMixtapeID());
        $query = $db -> prepare($sql);
        $query -> execute($params);
    }

    // Removes a mixtape with it's mixtapeRows from the database.
    public function removeMixtape($mixtapeID) {
        $db = $this -> connection();
        $sql = "DELETE FROM $this->dbTable WHERE " . self::$mixtapeID . " = ?";
        $params = array($mixtapeID);
        $query = $db -> prepare($sql);
        $query -> execute($params);

        $db = $this -> connection();
        $sql = "DELETE FROM $this->dbTableSecondary WHERE " . self::$mixtapeID . " = ?";
        $params = array($mixtapeID);
        $query = $db -> prepare($sql);
        $query -> execute($params);
    }
}