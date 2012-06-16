<?php
namespace galanthus\controller;

use galanthus\dispatcher\ResponseInterface,
    galanthus\dispatcher\RequestInterface,
    galanthus\controller\ControllerInterface,
    galanthus\dispatcher\request\Query,
    galanthus\di\Container;

abstract class Controller implements ControllerInterface
{
    
    protected $_request;
    
    protected $_response;
    
    protected $_injector;
    
    protected $_previous;
    
    public function __construct(Container $injector)
    {
        $this->_injector = $injector;
    }
    
    public function setRequest(RequestInterface $request)
    {
        $this->_request = $request;
        return $this;
    }
    
    public function getRequest()
    {
        return $this->_request;
    }
    
    public function setResponse(ResponseInterface $response)
    {
        $this->_response = $response;
        return $this;
    }
    
    public function getResponse()
    {
        return $this->_response;
    }
    
    public function setPrevious(ControllerInterface $controller)
    {
        $this->_previous = $controller;
        return $this;
    }
    
    protected function _getNamespace()
    {
        $reflection = new \ReflectionClass(get_class($this));
        return $reflection->getNamespaceName();
    }
    
    public function forward(Query $query)
    {
        if (!count($query)) {
            return $this->execute();
        }
        
        $next = $query->shift();
        
        /* @var $controller Controller */
        $controller = $this->_injector->create($this->_getNamespace() . '\\' . ucfirst($next));
        $controller->setRequest($this->getRequest())
                   ->setResponse($this->getResponse())
                   ->setPrevious($this)
                   ->forward($query);
    }
    
}