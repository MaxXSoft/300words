<?php

class Session {

  // make sure the requests from clients is not too frequent
  public static function validate() {
    session_start();
    if (!isset($_SESSION['lastreq'])) return false;
    // check time interval (must greater than 3 seconds)
    $last = $_SESSION['lastreq'];
    $now = new DateTime();
    $diff = $now->getTimestamp() - $last->getTimestamp();
    if ($diff <= 3) return false;
    // update session
    $_SESSION['lastreq'] = $now;
    return true;
  }

  // create new session
  public static function start() {
    session_start();
    if (isset($_SESSION['lastreq'])) {
      return self::validate();
    }
    else {
      $_SESSION['lastreq'] = new DateTime();
    }
    return true;
  }

}
