<?php

class SpotifyLinkedList implements Iterator  {
    private $track;
    private $next;
    private $previous;
    private $position;
    private $current;

    public function __construct(SpotifyTrack $track, SpotifyLinkedList $previous = NULL, $position = 0)
    {
        $this->previous = $previous;
        $this->position = $position+1;
        $this->track = $track;
        $this->next = null;
        $this->current = $this->track;
    }

    public function add(SpotifyTrack $track) {
        if($this->hasNext())
        {
            $this->next->add($track);
        }
        else
        {
            $newNode = new SpotifyLinkedList($track, $this, $this->position);
            $this->next = $newNode;
        }
    }

    public function rewind() {
        while($this->current->key() > 0)
        {
            $this->position -1;
            $this->next = $this;
            $this->current = $this->previous;
            $this->previous = $this->current->previous();
        }
    }

    public function previous() {
        return $this->previous;
    }

    public function current() {
        return $this->current;
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        $this->previous = $this->current;
        $this->current = $this->next;
    }

    public function valid() {
        return !is_null($this->current);
    }

    public function hasNext() {
        if($this->next != NULL)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getTrack() {
        return $this->track;
    }

    public function toArray() {
        $arr = array();

        $arr[] = $this->track;

        if($this->hasNext())
        {
            $arr .= $this->next->toArray();
        }

        return $arr;
    }
}