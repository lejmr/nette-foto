<?php

/**
 * My Application bootstrap file.
 */
use Nette\Application\Routers\Route;


// Load Nette Framework
require LIBS_DIR . '/Nette/Nette/loader.php';


// Configure application
$configurator = new Nette\Config\Configurator;

// Enable Nette Debugger for error visualisation & logging
//$configurator->setDebugMode($configurator::AUTO);
$configurator->enableDebugger(__DIR__ . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(APP_DIR)
	->addDirectory(LIBS_DIR)
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon');
$container = $configurator->createContainer();

// Setup router

$container->router[] = new Route('[<url>]/nahled', 
	 array( "presenter" => "Gallery", "action" => "thumbnail",
    "url" => array(
		Route::FILTER_OUT => NULL, 
       Route::PATTERN => ".*",        
	),) );

$container->router[] = new Route('[<url>]/preview', 
	 array( "presenter" => "Gallery", "action" => "preview",
	 "url" => array(
		Route::FILTER_OUT => NULL, 
       Route::PATTERN => ".*",        
	),) );

$container->router[] = new Route('[<url>/]', 
	 array( "presenter" => "Gallery", "action" => "default",
    "url" => array(
		Route::FILTER_OUT => NULL, 
       Route::PATTERN => ".*",        
	),) );

// Configure and run the application!
$container->application->run();
