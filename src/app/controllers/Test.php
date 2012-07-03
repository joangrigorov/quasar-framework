<?php
namespace app\controllers;

use galanthus\controller\Controller;

class Test extends Controller
{
    
    protected $paramsMap = array('name' => null);
    
    public function execute()
    {
        $this->response->name = $this->_getParam('name');
    }
}