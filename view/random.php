<?php

require_once 'page.php';

class RandomPageView extends PageView {

  // database object
  private $dbo = null;

  // information of posts
  private $posts = null;

  // information of infobar
  private $info = null;

  // prompt text in 'difference' method
  // type: array(string => string)
  private $diffPrompt = null;

  // constructor
  public function __construct() {
    parent::__construct();
    // initialize
    $this->using('dbo.php');
    $this->using('iterator.php');
    $this->dbo = new DBObject();
    $this->setCurrentTab(0);
    // get random story
    $this->selectRandPost();
  }

  // select a post randomly
  private function selectRandPost() {
    // generate random position
    $count = $this->dbo->getPostCount();
    $pos = rand(0, $count - 1);
    // get post info
    $current = $this->dbo->getPostList($pos, 1)[0];
    $this->posts = $this->dbo->getPostPath($current['id']);
    // reduce the length of path
    if (count($this->posts) > __300WORDS_MAX_POST_COUNT__) {
      $path = array_slice($this->posts, -(__300WORDS_MAX_POST_COUNT__ - 1));
      array_unshift($path, $this->posts[0],
                    -(count($this->posts) - __300WORDS_MAX_POST_COUNT__));
      $this->posts = $path;
    }
    // get post info of whole path
    foreach ($this->posts as &$i) {
      if ($i < 0) {
        $i = array('id' => null, 'count' => -$i);
      }
      else if ($i != $current['id']) {
        $i = $this->dbo->getPostInfo($i);
      }
      else {
        $i = $current;
      }
    }
    // read infobar infomation
    $this->info = array(
      'child'   => $this->dbo->getChildPostCount($current['id']),
      'comment' => $this->dbo->getCommentCount($current['id']),
    );
  }

  // get iterator of post contents
  protected function contents() {
    return new TrivialIterator($this->posts);
  }

  // get infobar infomation
  protected function info() {
    return $this->info;
  }

  // set the prompt text
  protected function setPrompt($prompt) {
    $this->diffPrompt = $prompt;
  }

  // echo date difference
  protected function difference($date) {
    // get target date (which time is set to zero)
    $target = new DateTime($date);
    $target->setTime(0, 0, 0);
    // calculate difference
    $now = new DateTime();
    $now->setTime(0, 0, 0);
    $diff = $target->diff($now)->format('%a');
    // echo result
    if ($diff == 0) {
      printf($this->diffPrompt['today'],
             (new DateTime($date))->format('H:i'));
    }
    else if ($diff == 1) {
      printf($this->diffPrompt['yesterday'], $diff);
    }
    else if ($diff < 31) {
      printf($this->diffPrompt['days'], $diff);
    }
    else if ($diff < 366) {
      $diff = $target->diff($now);
      $month = $diff->y * 12 + $diff->m + $diff->d / 30;
      printf($this->diffPrompt['months'], (int)round($month));
    }
    else {
      printf($this->diffPrompt['years'],
             $target->diff($now)->format('%y'));
    }
  }

  public function render($args) {
    $this->begin();
    $this->need('post-random.php');
    $this->end();
  }

}
