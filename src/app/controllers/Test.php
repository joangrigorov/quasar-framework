<?php
namespace app\controllers;

use galanthus\controller\Controller;

class Test extends Controller
{
    
    protected $_paramsMap = array('name' => null, 'bot' => null);
    
    public function execute()
    {
        echo $this->_getParam('name') . ' - ' . $this->_getParam('bot');
    }
}