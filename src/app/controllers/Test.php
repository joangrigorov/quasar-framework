<?php
namespace app\controllers;

use galanthus\di\Container,
    galanthus\db\TableGateway,
    galanthus\controller\Controller;

class Test extends Controller
{
    
    protected $paramsMap = array('name' => 'Joan-Alexander Grigorov');
    
    public function __construct(TableGateway $gateway)
    {
        var_dump($gateway->fetchAll());
        die;
    }
    
    public function execute()
    {
        $this->response->name = $this->getParam('name');
    }
}