<?php
namespace app\controllers;

use galanthus\dispatcher\request\Query,
    galanthus\controller\Controller;

class Root extends Controller
{
    protected $_paramsMap = array('test' => null, 'bot' => null);
    
    public function execute()
    {
        echo $this->_getParam('test');
    }
}