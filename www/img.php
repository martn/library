<?php

// absolute filesystem path to the web root
define('WWW_DIR', dirname(__FILE__));

// scripts directory
define('SCRIPTS_DIR', WWW_DIR . '/scripts');

// absolute filesystem path to the application root
define('APP_DIR', SCRIPTS_DIR . '/app');

// absolute filesystem path to the libraries
define('LIBS_DIR', SCRIPTS_DIR . '/libs');

// load bootstrap file
require APP_DIR . '/imgbootstrap.php';   