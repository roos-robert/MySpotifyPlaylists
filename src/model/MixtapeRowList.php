<?php

namespace model;

class MixtapeRowList {
    private $mixtapeRows;

    public function __construct() {
        $this->mixtapeRows = array();
    }

    public function toArray() {
        return $this->mixtapeRows;
    }

    public function add(MixtapeRowModel $mixtapeRows) {
        if (!$this->contains($mixtapeRows))
            $this->mixtapeRows[] = $mixtapeRows;
    }

    public function contains(MixtapeRowModel $mixtapeRows) {
        foreach($this->mixtapeRows as $key => $value) {
            if ($mixtapeRows->equals($value)) {
                return true;
            }
        }
        return false;
    }
}