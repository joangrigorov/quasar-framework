<?php

// Define path to the root directory
defined('ROOT_PATH')
    || define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));

require_once ROOT_PATH . '/configs/bootstrap.php';

new app\controllers\TestController;