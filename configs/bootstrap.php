<?php

// Add the src/ directory to the include path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(ROOT_PATH . '/src'),
    get_include_path(),
)));

defined('DS') || define('DS', DIRECTORY_SEPARATOR);

// register the autoloader function
spl_autoload_register(include ROOT_PATH . '/configs/autoloader.php');