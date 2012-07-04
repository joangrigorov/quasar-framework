<?php

// Add the src/ directory to the include path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(ROOT_PATH . '/src'),
    get_include_path(),
)));

defined('DS') || define('DS', DIRECTORY_SEPARATOR);

// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// register the autoloader function
spl_autoload_register(include ROOT_PATH . '/configs/autoloader.php');

// turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// create the injector
$injector = new galanthus\di\Container(include ROOT_PATH . '/configs/di/global.php');

// add common configuration
$injector->addConfig(include ROOT_PATH . '/configs/di/common.php');
// add environment specific configuration
$injector->addConfig(include ROOT_PATH . '/configs/di/env.' . APPLICATION_ENV . '.php');

// set the container to inject itself and use single instance
$injector->forVariable('injector')->willUse($injector);

// create the dispatcher object
/* @var $dispatcher galanthus\dispatcher\Dispatcher */
$dispatcher = $injector->create('dispatcher');
echo $dispatcher->dispatch()->output();