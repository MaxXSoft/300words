<?php

require_once 'page.php';

class AboutPageView extends PageView {

  public function __construct() {
    parent::__construct();
    $this->setCurrentTab(-1);
    $this->setTitle('关于');
  }

  public function render($args) {
    $this->begin();
    $this->need('about.php');
    $this->end();
  }

}
