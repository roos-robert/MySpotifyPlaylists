<?php

namespace model;

class MixtapeRowModel {
    private $mixtapeRowID;
    private $mixtapeID;
    private $song;
    private $picture;

    public function __construct($mixtapeID, $song) {
        $this->mixtapeID = $mixtapeID;
        $this->song = $song;
    }

    public function getSong() {
        return $this->song;
    }

    public function getMixtapeRowID() {
        return $this->mixtapeRowID;
    }

    public function getMixtapeID() {
        return $this->mixtapeID;
    }

    public function setMixtapeRowID($mixtapeID) {
        $this->mixtapeRowID = $mixtapeID;
    }
}