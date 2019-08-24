<?php

class TrivialIterator {

  // array that needs to be iterated
  private $array = null;

  // current index
  private $index = 0;

  public function __construct($array) {
    $this->array = $array;
  }

  // get current index
  public function index() {
    return $this->index;
  }

  // get current key
  public function key() {
    return key($this->array);
  }

  // get current value
  public function value() {
    return current($this->array);
  }

  // get value by its index
  // NOTE: this method will reset the internal state of current iterator
  public function getValueByIndex($index) {
    if ($index < 0) return null;
    // reset internal state
    reset($this->array);
    $this->index = 0;
    // get by index
    $i = 0;
    $value = null;
    while ($cur = current($this->array)) {
      if ($i == $index) {
        $value = $cur;
        break;
      }
      next($this->array);
      ++$i;
    }
    // reset again
    reset($this->array);
    return $value;
  }

  // select next element
  public function next() {
    $this->index++;
    return next($this->array);
  }

  // check if is last element
  public function isLast() {
    return $this->index == count($this->array) - 1;
  }

  // return the last value of array
  public function last() {
    return end($this->array);
  }

}
