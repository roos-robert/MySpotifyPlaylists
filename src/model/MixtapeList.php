<?php

namespace model;

class MixtapeList {
    private $mixtapes;

    public function __construct() {
        $this->mixtapes = array();
    }

    public function toArray() {
        return $this->mixtapes;
    }

    public function add(MixtapeModel $mixtape) {
        if (!$this->contains($mixtape))
            $this->mixtapes[] = $mixtape;
    }

    public function contains(MixtapeModel $mixtape) {
        foreach($this->mixtapes as $key => $value) {
            if ($mixtape->equals($value)) {
                return true;
            }
        }
        return false;
    }
}