<?php
namespace app\controllers;

use galanthus\controller\ControllerInterface;

class TestController implements ControllerInterface
{
    public function __construct()
    {
        echo 'Hello world';
    }
}