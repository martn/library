<?php
/**
 * My Application bootstrap file.
 *
 * @copyright  Copyright (c) 2009 John Doe
 * @package    MyApplication
 * @version    $Id: bootstrap.php 208 2009-02-09 14:33:34Z david@grudl.com $
 */


// Step 1: Load Nette Framework
// this allows load Nette Framework classes automatically so that
// you don't have to litter your code with 'require' statements
require_once LIBS_DIR . '/Nette/loader.php';
require_once LIBS_DIR . '/dibi/dibi.php';
//require_once dirname(__FILE__) . '/../../../Nette/loader.php';

// Step 2: Configure environment
// 2a) enable Nette\Debug for better exception and error visualisation


//Debug::enable();

if(isset($_REQUEST['id'])) {

 // 2b) load configuration from config.ini file
    Environment::loadConfig();

    // 2c) enable RobotLoader - this allows load all classes automatically
    $loader = new RobotLoader();
    $loader->addDirectory(LIBS_DIR);
    $loader->register();
}    