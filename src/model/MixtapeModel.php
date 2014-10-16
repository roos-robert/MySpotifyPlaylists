<?php

namespace model;

class MixtapeModel {
    private $mixtapeID;
    private $userID;
    private $name;
    private $picture;

    public function __construct($mixtapeID, $userID, $name, $picture) {
        $this->mixtapeID = $mixtapeID;
        $this->userID = $userID;
        $this->name = $name;
        $this->picture = $picture;
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
}