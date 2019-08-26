<?php

require_once 'view.php';

class PostView extends View {

  // database object
  private $dbo = null;

  // constructor
  public function __construct() {
    $this->using('dbo.php');
    $this->dbo = new DBObject();
  }

  // get word count
  private function getWordCount($text) {
    preg_match_all('/[\x{4e00}-\x{9fa5}]/u', $text, $chinese);
    preg_match_all('/\w+/', $text, $english);
    $chineseLen = count($chinese[0]);
    $englishLen = count($english[0]);
    return $chineseLen + $englishLen;
  }

  // check user name
  private function checkUsername($username) {
    $reUsername = '/^(?:[0-9a-zA-Z_\x{4e00}-\x{9fa5}]|(?:(?:[0-9#][\x{20E3}])|[\x{00ae}\x{00a9}\x{203C}\x{2047}\x{2048}\x{2049}\x{3030}\x{303D}\x{2139}\x{2122}\x{3297}\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?))+$/u';
    preg_match_all($reUsername, $username, $result);
    if (!count($result[0])) return false;
    $len = mb_strlen($result[0][0]);
    return $len > 0 && $len <= 16;
  }

  // make sure the requests from clients is not too frequent
  private function checkFrequency() {
    session_start();
    if (!isset($_SESSION['lastreq'])) return false;
    // check time interval (must greater than 3 seconds)
    $last = $_SESSION['lastreq'];
    $now = new DateTime();
    $diff = $now->getTimestamp() - $last->getTimestamp();
    if ($diff <= 3) return false;
    // update session
    $_SESSION['lastreq'] = $now;
  }

  // validate post data
  private function validateData($args) {
    // check username
    if (!$this->checkUsername($_POST['user'])) return false;
    // check content length
    $count = $this->getWordCount($_POST['content']);
    $len = mb_strlen($_POST['content']);
    if ($count == 0 || $count > 300 || $len > 600) return false;
    return true;
  }

  // create new session
  public static function createSession() {
    session_start();
    if (isset($_SESSION['lastreq'])) {
      return $this->checkFrequency();
    }
    else {
      $_SESSION['lastreq'] = new DateTime();
    }
    return true;
  }

  public function render($args) {
    $error = false;
    $resp = null;
    // validate data first
    if (!$this->checkFrequency() || !$this->validateData($args)) {
      $error = true;
    }
    else {
      // perform operations
      switch ($args[0]) {
        case 'story': {
          $resp = $this->dbo->newPost($_POST['parent'], $_POST['user'],
                                      $_POST['content']);
          break;
        }
        case 'comment': {
          $resp = $this->dbo->newComment($_POST['post'], $_POST['parent'],
                                         $_POST['user'], $_POST['content']);
          break;
        }
        default: {
          $error = true;
          break;
        }
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
