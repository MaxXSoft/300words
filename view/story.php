<?php

require_once 'page.php';

class StoryPageView extends PageView {

  public function __construct() {
    parent::__construct();
    $this->setCurrentTab(0);
  }

  public function render($args) {
    // initialize parameters
    $this->setPostId((int)$args[0]);
    $this->setFromRoot($args[1] == 'fromroot');
    // render page
    $this->begin();
    $this->need('post-box.php');
    $this->end();
  }

}
