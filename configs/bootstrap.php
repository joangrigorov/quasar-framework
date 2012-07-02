<?php

// Add the src/ directory to the include path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(ROOT_PATH . '/src'),
    get_include_path(),
)));

defined('DS') || define('DS', DIRECTORY_SEPARATOR);

// register the autoloader function
spl_autoload_register(include ROOT_PATH . '/configs/autoloader.php');

// turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// create the injector
$injector = new galanthus\di\Container(include ROOT_PATH . '/configs/di/global.php');
// set the container to inject itself and use single instance
$injector->forVariable('injector')->willUse($injector);

// create the dispatcher object
/* @var $dispatcher galanthus\dispatcher\Dispatcher */
$dispatcher = $injector->create('dispatcher');
$dispatcher->dispatch()
           ->output();