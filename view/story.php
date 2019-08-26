<?php

require_once 'page.php';

class StoryPageView extends PageView {

  // database object
  private $dbo = null;

  public function __construct() {
    parent::__construct();
    $this->using('dbo.php');
    $this->dbo = new DBObject();
    $this->setCurrentTab(0);
  }

  public function render($args) {
    $id = (int)$args[0];
    $info = $this->dbo->getPostInfo($id);
    $title = preg_split('/[\r\n]+/', trim($info['post']))[0];
    // initialize parameters
    $this->setTitle($title);
    $this->setPostId($id);
    $this->setFromRoot($args[1] == 'fromroot');
    // render page
    PostView::createSession();
    $this->begin();
    $this->need('post-box.php');
    $this->end();
  }

}
