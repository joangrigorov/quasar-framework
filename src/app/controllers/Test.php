<?php
namespace app\controllers;

use galanthus\dispatcher\request\Query,
    galanthus\controller\Controller;

class Test extends Controller
{
    public function execute()
    {
        echo __CLASS__;
    }
}