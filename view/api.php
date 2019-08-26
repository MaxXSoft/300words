<?php

require_once 'view.php';

class APIView extends View {

  // database object
  private $dbo = null;

  // constructor
  public function __construct() {
    $this->using('dbo.php');
    $this->dbo = new DBObject();
  }

  public function render($args) {
    $error = false;
    $resp = null;
    // check parameters and perform operations
    switch ($args[0]) {
      case "info": {
        $resp = $this->dbo->getPostInfo($args[1]);
        break;
      }
      case "path": {
        $resp = $this->dbo->getPostPath($args[1]);
        break;
      }
      case "postcount": {
        $resp = $this->dbo->getPostCount();
        break;
      }
      case "post": {
        $resp = $this->dbo->getPostList($args[1], $args[2]);
        break;
      }
      case "latest": {
        $resp = $this->dbo->getPostListLatest($args[1], $args[2]);
        break;
      }
      case "hot": {
        $resp = $this->dbo->getPostListHot($args[1], $args[2]);
        break;
      }
      case "rootcount": {
        $resp = $this->dbo->getRootPostCount();
        break;
      }
      case "root": {
        $resp = $this->dbo->getRootPostList($args[1], $args[2]);
        break;
      }
      case "childcount": {
        $resp = $this->dbo->getChildPostCount($args[1]);
        break;
      }
      case "child": {
        $resp = $this->dbo->getChildPostList($args[1], $args[2], $args[3]);
        break;
      }
      case "commentcount": {
        $resp = $this->dbo->getCommentCount($args[1], $args[2]);
        break;
      }
      case "comment": {
        $resp = $this->dbo->getCommentList($args[1], $args[2], $args[3]);
        break;
      }
      case "subcount": {
        $resp = $this->dbo->getSubCommentCount($args[1]);
        break;
      }
      case "sub": {
        $resp = $this->dbo->getSubCommentList($args[1], $args[2], $args[3]);
        break;
      }
      default: {
        $error = true;
        break;
      }
    }
    // send response
    header('Content-Type: application/json; charset=utf8');
    echo(json_encode(array(
      "error"     => $error,
      "response"  => $resp,
    )));
  }

}
