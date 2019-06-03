<?php

  /**
   *  Clase para modelar books
   *
   */
  class Book {

    public $book;
    public $minimum_price;
    public $maximum_price;
    public $minimum_amount;
    public $maximum_amount;
    public $minimum_value;
    public $maximum_value;
    public $status;

    public function __construct($book, $minimum_price, $maximum_price, $minimum_amount, $maximum_amount, $minimum_value, $maximum_value, $status) {
        $this->book = $book;
        $this->minimum_price = $minimum_price;
        $this->maximum_price = $maximum_price;
        $this->minimum_amount = $minimum_amount;
        $this->maximum_amount = $maximum_amount;
        $this->minimum_value = $minimum_value;
        $this->maximum_value = $maximum_value;
        $this->status = $status;
    }
  }
 ?>
