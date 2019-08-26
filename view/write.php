<?php

require_once 'page.php';

class WritePageView extends PageView {

  public function __construct() {
    parent::__construct();
    $this->setCurrentTab(3);
    $this->setTitle('写故事');
  }

  public function render($args) {
    $this->begin();
    $this->need('new-story.php');
    $this->end();
  }

}
