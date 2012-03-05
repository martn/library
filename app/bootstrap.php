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
//require_once dirname(__FILE__) . '/../../../Nette/loader.php';
// Step 2: Configure environment
// 2a) enable Nette\Debug for better exception and error visualisation

//NDebug::enable(NDebug::PRODUCTION, LOGS_DIR .'/logs.log');
NDebug::enable(NDebug::DEVELOPMENT);

//NDebug::$strictMode = true;
// 2c) enable RobotLoader - this allows load all classes automatically
//$loader = new NRobotLoader();
//$loader->setCacheStorage(APP_DIR."/temp");
//$loader->addDirectory(array(LIBS_DIR, APP_DIR, MODELS_DIR));
//$loader->register();
//NDebug::dump(" slkdjflskjdflkjl");
// 2d) setup sessions
$session = NEnvironment::getSession();
$session->setSavePath(TEMP_DIR . '/sessions/');


//Debug::addPanel(new TodoPanel());
//NDebug::renderPanel();
// 2b) load configuration from config.ini file
NEnvironment::loadConfig();

// parametr logov√°n√≠ chyb je NULL, tak≈æe se rozhodne podle autodetekce z Environment podle ≈ôe≈æimu production, tzn: Environment::isProduction() ? 'logovat' : 'zobrazovat'
//Environment::setMode('production', Environment::PRODUCTION);
//Debug::dump($config);
//if (!Environment::isProduction()) Debug::enableProfiler();
//RoutingDebugger::enable();
// Step 3: Configure application
// 3a) get and setup a front controller
$application = NEnvironment::getApplication();

//$application->errorPresenter = 'Error';
//$application->catchExceptions = FALSE;
// Step 4: Setup application router
$router = $application->getRouter();


NRoute::setStyleProperty('presenter', NRoute::FILTER_TABLE, array(
            'novinky' => 'News',
            'kontakt' => 'Contact',
            'onas' => 'AboutUs',
            'uzivatele' => 'Users',
            'skupiny' => 'Groups',
            'sekce' => 'Sections',
            'typy' => 'Types',
            'knihovna' => 'Default',
        ));



NRoute::setStyleProperty('action', NRoute::FILTER_TABLE, array(
            'archiv' => 'archive',
            'seznam' => 'list',
            'novy' => 'new',
            'upravit' => 'edit',
        ));


/*
  $router[] = new Route('feed/<presenter>/<lang [a-z]{2}>', array(
  'module' => 'Feed',
  'presenter' => 'Default',
  'action' => 'default',
  'lang' => 'cs',
  ));



  $router[] = new Route('admin/<presenter>/<action>/<id>/<lang> [a-z]{2}', array(
  'module' => 'Admin',
  'presenter' => 'Default',
  'action' => 'default',
  'lang' => 'en',
  'id' => NULL
  ));
 */

$router[] = new NRoute('<presenter>/<action>/<id>', array(
            'module' => 'Front',
            'presenter' => 'Default',
            'lang' => 'cs',
            'action' => 'default',
            'id' => ''
//     'id' => NULL // takto definovanƒÇÀù parametr je volitelnƒÇÀù
        ));


/*
  $router[] = new Route('<presenter>/<action>/<item>', array(
  'module' => 'Front',
  'presenter' => 'Default',
  'action' => 'default',
  'lang' => 'cs',
  'item' => ''
  //     'id' => NULL // takto definovanƒÇÀù parametr je volitelnƒÇÀù
  )); */


$router[] = new NRoute('index.php', array(
            'module' => 'Front',
            'presenter' => 'Default',
            'action' => 'default',
        ));



MultipleFileUpload::register();
MultipleFileUpload::getUIRegistrator()->clear()->register('MFUUISwfupload');

NFormContainer::extensionMethod('NFormContainer::addRequestButton', array('RequestButtonHelper', 'addRequestButton'));
NFormContainer::extensionMethod('NFormContainer::addRequestButtonBack', array('RequestButtonHelper', 'addRequestButtonBack'));
NFormContainer::extensionMethod("NFormContainer::addDependentSelectBox", array("DependentSelectBox", "formAddDependentSelectBox"));
NFormContainer::extensionMethod('NFormContainer::addDatePicker', array("DatePicker", "addDatePicker"));
FormMacros::register();


// Step 5: Run the application!
$application->run();