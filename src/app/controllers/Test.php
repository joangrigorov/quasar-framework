<?php
namespace app\controllers;

use galanthus\controller\Controller;

class Test extends Controller
{
    
    protected $paramsMap = array('name' => 'Joan-Alexander Grigorov');
    
    public function execute()
    {
        $this->response->name = $this->getParam('name');
    }
}