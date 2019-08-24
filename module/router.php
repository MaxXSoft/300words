<?php

class Router {

  // prefix of requested URI
  private static $prefix = null;

  // route table that mapping strings to renderable objects
  // type: array(string => (void -> IRenderable))
  private static $routeTable = null;

  // error handler
  // will be used when the match fails
  // type: void -> IRenderable
  private static $errorHandler = null;

  // initialize router with route table
  public static function init($prefix, $routeTable) {
    self::$prefix = $prefix;
    self::$routeTable = $routeTable;
  }

  // set error handler
  public static function setErrorHandler($errorHandler) {
    self::$errorHandler = $errorHandler;
  }

  // parse requested URI and call target function
  public static function parse($uri) {
    // get requested array
    $req = substr($uri, strlen(self::$prefix));
    $req = trim($req, '/');
    $req = preg_split('/\/+/', $req);
    // try to match renderable object in table
    $renderObj = self::$routeTable[$req[0]];
    if ($renderObj !== null) {
      // render the response
      $renderObj()->render(array_slice($req, 1));
    }
    else if (self::$errorHandler !== null) {
      // call error handler
      self::$errorHandler()->render($req);
    }
    else {
      // just return a 404 error
      http_response_code(404);
      die("Error, '{$uri}' not found!");
    }
  }
}
