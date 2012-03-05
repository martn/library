<?php

// absolute filesystem path to the web root
define('WWW_DIR', dirname(__FILE__));

// absolute filesystem path to the application root
define('APP_DIR', WWW_DIR . '/../app');

// absolute filesystem path to the libraries
define('LIBS_DIR', WWW_DIR . '/../libs');

define('LOGS_DIR', WWW_DIR . '/../log');

// absolute filesystem path to the temporary files
define('TEMP_DIR', WWW_DIR . '/../temp');

define('DBDATA_DIR', WWW_DIR . '/../dbData');

define('DBFILE_DIR', DBDATA_DIR . '/files');

// absolute filesystem path to the components root
define('COMPONENTS_DIR', APP_DIR . '/components');

// absolute filesystem path to the models root
define('MODELS_DIR', APP_DIR . '/models');

// absolute filesystem path to the locale 
define('LOCALE_DIR', APP_DIR . '/locale');

// load bootstrap file
require APP_DIR . '/bootstrap.php';