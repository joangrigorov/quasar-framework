<?php
namespace app\controllers;

use Galanthus\Controller\ControllerInterface;

class TestController implements ControllerInterface
{
    public function __construct()
    {
        echo 'Hello world';
    }
}