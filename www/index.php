<?php

// absolute filesystem path to this web root
define('WWW_DIR', __DIR__);

// absolute filesystem path to the application root
define('APP_DIR', WWW_DIR . '/../app');

// absolute filesystem path to the libraries
define('LIBS_DIR', WWW_DIR . '/../libs');

define('PICS_DIR', WWW_DIR . '/../pictures');

define('CACHE_DIR', WWW_DIR.'/../temp/cache');

// It is going to be used as square with same size
define('THUMB_SIZE', 100);
define('IMAGE_SIZE', 1600);
define('FORCE_IMAGE_SIZE', TRUE);

// uncomment this line if you must temporarily take down your site for maintenance
// require APP_DIR . '/templates/maintenance.phtml';

// load bootstrap file
require APP_DIR . '/bootstrap.php';
