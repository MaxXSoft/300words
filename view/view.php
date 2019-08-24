<?php

require_once 'module/irender.php';

abstract class View implements IRenderable {

  // generate full URL by path
  protected function joinURL($path) {
    return __300WORDS_SITE_URL__ . $path;
  }

  // quote another component
  protected function need($path) {
    require __300WORDS_ROOT_DIR__ . "/view/component/{$path}";
  }  

  // using a module
  protected function using($module) {
    require_once __300WORDS_ROOT_DIR__ . "/module/{$module}";
  }

}
