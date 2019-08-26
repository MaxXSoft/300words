<?php

require_once 'page.php';

class RootPageView extends PageView {

  public function __construct() {
    parent::__construct();
    $this->setCurrentTab(3);
  }

  public function render($args) {
    $this->begin();
    $this->need('root-list.php');
    $this->end();
  }

}
