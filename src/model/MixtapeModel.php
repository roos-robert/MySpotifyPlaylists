<?php

namespace model;

class MixtapeModel {
    private $mixtapeID = NULL;
    private $userID;
    private $name;
    private $picture;

    public function __construct($userID, $name, $picture, $mixtapeID = NULL) {
        $this->userID = $userID;
        $this->name = $name;
        $this->picture = $picture;
        $this->mixtapeID = $mixtapeID ? $mixtapeID : NULL;
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

    public function setMixtapeID($mixtapeID) {
        $this->mixtapeID = $mixtapeID;
    }
}