<?php

require_once 'page.php';

class WritePageView extends PageView {

  // array of prompt texts
  private $prompt = null;

  public function __construct() {
    parent::__construct();
    $this->using('iterator.php');
    $this->using('session.php');
    $this->setCurrentTab(3);
    $this->setTitle('写故事');
  }

  // set prompt array
  protected function setPrompt($prompt) {
    $this->prompt = $prompt;
  }

  // echo prompt text randomly
  protected function prompt() {
    $text = $this->prompt[array_rand($this->prompt)];
    $lines = preg_split('/[\r\n]+/', trim($text));
    return new TrivialIterator($lines);
  }

  public function render($args) {
    Session::start();
    $this->begin();
    $this->need('new-story.php');
    $this->end();
  }

}
