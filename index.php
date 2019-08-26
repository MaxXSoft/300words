<?php

// include all necessary files
require_once 'config.php';
require_once 'module/router.php';
require_once 'view/random.php';
require_once 'view/list.php';
require_once 'view/about.php';
require_once 'view/write.php';
require_once 'view/story.php';
require_once 'view/api.php';
require_once 'view/post.php';

// initialize router
Router::init('/300words', array(
  ''        => function () { return new RandomPageView(); },
  'random'  => function () { return new RandomPageView(); },
  'hot'     => function () { return new ListPageView(1); },
  'latest'  => function () { return new ListPageView(2); },
  'root'    => function () { return new ListPageView(3); },
  'about'   => function () { return new AboutPageView(); },
  'new'     => function () { return new WritePageView(); },
  'story'   => function () { return new StoryPageView(); },
  'api'     => function () { return new APIView(); },
  'post'    => function () { return new PostView(); },
));

// parse
Router::parse($_SERVER['REQUEST_URI']);
