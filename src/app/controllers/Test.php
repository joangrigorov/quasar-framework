<?php
namespace app\controllers;

use galanthus\db\TableGatewayInterface;

use galanthus\di\Container,
    galanthus\db\TableGateway,
    galanthus\controller\Controller;

class Test extends Controller
{
    
    protected $paramsMap = array('name' => 'Joan-Alexander Grigorov');
    
    public function __construct(TableGateway $gateway)
    {
        var_dump($gateway->fetchAll($gateway->select(), TableGatewayInterface::FETCH_ASSOC));
        die;
    }
    
    public function execute()
    {
        $this->response->name = $this->getParam('name');
    }
}