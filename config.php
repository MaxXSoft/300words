<?php

// URL of current site
define('__300WORDS_SITE_URL__', '//localhost/300words/');
assert('substr(__300WORDS_SITE_URL__, -1) === "/"');

// organization name
define('__300WORDS_ORG_NAME__', 'MaxXSoft');

// root directory
define('__300WORDS_ROOT_DIR__', __DIR__);

// database setting
define('__300WORDS_PDO_HOST__', 'mysql');
define('__300WORDS_PDO_NAME__', MYSQL_DATABASE);
define('__300WORDS_PDO_USER__', MYSQL_USERNAME);
define('__300WORDS_PDO_PASS__', MYSQL_PASSWORD);

// maximum number of posts in story page
define('__300WORDS_MAX_POST_COUNT__', 10);

// number of comments per page
define('__300WORDS_COMMENTS_PER_PAGE__', 10);
