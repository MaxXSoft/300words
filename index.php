<?php

// include all necessary files
require_once 'config.php';
require_once 'module/router.php';
require_once 'view/random.php';
require_once 'view/api.php';

// initialize router
Router::init('/300words', array(
  ''        => function () { return new RandomPageView(); },
  'random'  => function () { return new RandomPageView(); },
  // 'hot'     => function () { return new HotPageView(); },
  // 'latest'  => function () { return new LatestPageView(); },
  // 'root'    => function () { return new RootPageView(); },
  // 'about'   => function () { return new AboutPageView(); },
  // 'new'     => function () { return new WritePageView(); },
  // 'story'   => function () { return new StoryPageView(); },
  'api'     => function () { return new APIView(); },
));

// parse
Router::parse($_SERVER['REQUEST_URI']);
