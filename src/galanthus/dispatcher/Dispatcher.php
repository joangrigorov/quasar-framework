<?php

namespace galanthus\dispatcher;

use galanthus\di\Container;

class Dispatcher implements DispatcherInterface
{
    
    const DEFAULT_ROOT_CONTROLLER = 'app\controllers\Root';
    
    protected $_request;
    
    protected $_response;
    
    protected $_injector;
    
    public function __construct(Request $request, Response $response, Container $injector)
    {
        $this->_request = $request;
        $this->_response = $response;
        $this->_injector = $injector;
    }
    
    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->_request;
    }
    
    public function dispatch($rootController = self::DEFAULT_ROOT_CONTROLLER)
    {
        $query = $this->getRequest()->getQuery();
        
        $controller = $this->_injector->create($rootController);
        
        if (!$controller instanceof \galanthus\controller\ControllerInterface) {
            throw new DispatcherException('The requested controller must implement ControllerInterface');
        }
        
        $controller->setRequest($this->_request)
                   ->setResponse($this->_response)
                   ->forward($query);
        
        return $this;
    }
    
    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->_response;
    }
    
    public function output()
    {
        $this->getResponse()->output();
    }
    
}