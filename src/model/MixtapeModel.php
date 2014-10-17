<?php

namespace model;

class MixtapeModel {
    private $mixtapeID = NULL;
    private $userID;
    private $name;
    private $picture;
    private $creationDate;

    public function __construct($userID, $name, $picture, $mixtapeID = NULL, $creationDate = NULL) {
        $this->userID = $userID;
        $this->name = $name;
        $this->picture = $picture;
        $this->mixtapeID = $mixtapeID ? $mixtapeID : NULL;
        $this->creationDate = $creationDate ? $creationDate : NULL;
    }

    public function getName() {
        return $this->name;
    }

    public function getMixtapeID() {
        return $this->mixtapeID;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getPicture() {
        return $this->picture;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function setMixtapeID($mixtapeID) {
        $this->mixtapeID = $mixtapeID;
    }
}