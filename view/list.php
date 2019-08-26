<?php

require_once 'page.php';

class ListPageView extends PageView {

  public function __construct($selTab) {
    parent::__construct();
    $this->setCurrentTab($selTab);
  }

  public function render($args) {
    $this->begin();
    $this->need('story-list.php');
    $this->end();
  }

}
