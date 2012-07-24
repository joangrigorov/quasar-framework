<?php
namespace app\controllers;

use galanthus\db\TableGatewayInterface;

use galanthus\di\Container,
    galanthus\db\TableGateway,
    galanthus\controller\Controller;

class Test extends Controller
{
    
    protected $paramsMap = array('name' => 'Joan-Alexander Grigorov');
    
    protected $gateway;
    
    public function __construct(TableGateway $gateway = null)
    {
        $this->gateway = $gateway;
    }
    
    public function execute()
    {
        $gateway = $this->gateway;
        $this->response->files = $gateway->fetchAll();
        $this->response->name = $this->getParam('name');
    }
}