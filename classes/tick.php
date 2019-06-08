<?php

  /**
   *  Clase para modelar ticks
   *
   */
  class Tick {

    public $id;
    public $book;
    public $volume;
    public $last;
    public $high;
    public $low;
    public $vwap;
    public $ask;
    public $bid;
    public $created_at;
    public $status;

    public function __construct($id, $book, $volume, $last, $high, $low, $vwap, $ask, $bid, $created_at, $status) {
        $this->id = $id;
        $this->book = $book;
        $this->volume = $volume;
        $this->last = $last;
        $this->high = $high;
        $this->low = $low;
        $this->vwap = $vwap;
        $this->ask = $ask;
        $this->bid = $bid;
        $this->created_at = $created_at;
        $this->status = $status;
    }
  }
 ?>
