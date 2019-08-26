<?php

require_once 'page.php';

class RandomPageView extends PageView {

  // database object
  private $dbo = null;

  // constructor
  public function __construct() {
    parent::__construct();
    // initialize internal object
    $this->using('dbo.php');
    $this->dbo = new DBObject();
    // initialize properties
    $this->setCurrentTab(0);
    $this->setFromRoot(false);
    // get random story
    $this->selectRandPost();
  }

  // select a post randomly
  private function selectRandPost() {
    $this->setPostId($this->dbo->getRandomPostId());
  }

  public function render($args) {
    PostView::createSession();
    $this->begin();
    $this->need('post-box.php');
    $this->end();
  }

}
