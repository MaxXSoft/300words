<?php

require_once 'view.php';

abstract class PageView extends View {

  // all tabs of '300words' site (string array)
  private static $tabs = null;

  // index of current tab
  private static $currentTab = 0;

  // page title
  private static $title = null;

  // current post id
  private static $currentPostId = null;

  // 'view from root' flag
  private static $flagFromRoot = false;

  // constructor
  public function __construct() {
    $this->using('iterator.php');
  }

  // set tabs array
  protected function setTabs($tabs) {
    self::$tabs = $tabs;
  }

  // get iterator of tabs
  protected function tabs() {
    return new TrivialIterator(self::$tabs);
  }

  // set current tab
  // 0: random story, 1: hot story, 2: latest story, 3: root list
  protected function setCurrentTab($current) {
    self::$currentTab = $current;
  }

  // get current tab
  protected function currentTab() {
    return self::$currentTab;
  }

  // set page title
  // if parameter 'title' is null, set name of current tab as title
  protected function setTitle($title = null) {
    self::$title = $title;
  }

  // echo page title
  protected function title() {
    $title = self::$title;
    // check if current title is null
    if (is_null($title) && self::$currentTab >= 0) {
      // use name of current tab as title
      $it = new TrivialIterator(self::$tabs);
      $title = $it->getValueByIndex(self::$currentTab);
    }
    echo($title);
  }

  // echo max post count
  protected function maxPostCount() {
    echo(__300WORDS_MAX_POST_COUNT__);
  }

  // echo comments per page
  protected function commentsPerPage() {
    echo(__300WORDS_COMMENTS_PER_PAGE__);
  }

  // set current post id
  protected function setPostId($postId) {
    self::$currentPostId = $postId;
  }

  // echo current post id
  protected function postId() {
    echo(self::$currentPostId === null ? 'null' : self::$currentPostId);
  }

  // set 'view from root' flag
  protected function setFromRoot($fromRoot) {
    self::$flagFromRoot = $fromRoot;
  }

  // echo 'view from root' flag
  protected function fromRoot() {
    echo(self::$flagFromRoot ? 'true' : 'false');
  }

  // echo a URL
  protected function url($path) {
    echo($this->joinURL($path));
  }

  // echo a URL of CSS file
  protected function css($path) {
    echo($this->joinURL("view/css/{$path}"));
  }

  // echo a URL of image file
  protected function image($path) {
    echo($this->joinURL("view/image/{$path}"));
  }

  // echo a URL of script file
  protected function script($path) {
    echo($this->joinURL("view/script/{$path}"));
  }

  // echo a URL of main script file
  protected function scriptMain() {
    switch (self::$currentTab) {
      case 0: {
        // random story
        $this->script('main.js');
        break;
      }
      case 1: case 2: case 3: {
        // hot/latest/root list
        $this->script('list.js');
        break;
      }
    }
  }

  // echo current year
  protected function year() {
    echo(date('Y'));
  }

  // render the header and navigation bar of current page
  protected function begin() {
    $this->need('header.php');
    $this->need('navibar.php');
  }

  // render the footer of current page
  protected function end() {
    $this->need('footer.php');
  }

}
