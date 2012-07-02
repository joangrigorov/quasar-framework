<?php

namespace galanthus\dispatcher;

use galanthus\di\Container;

class Dispatcher implements DispatcherInterface
{
    
    /**
     * The request object
     * 
     * @var RequestInterface
     */
    protected $_request;
    
    /**
     * The response object
     * 
     * @var ResponseInterface
     */
    protected $_response;
    
    /**
     * The dependency injection container
     * 
     * @var Container
     */
    protected $_injector;
    
    /**
     * Constructor 
     * 
     * Sets dependencies
     * 
     * @param Request $request
     * @param Response $response
     * @param Container $injector
     */
    public function __construct(Request $request, Response $response, Container $injector)
    {
        $this->_request = $request;
        $this->_response = $response;
        $this->_injector = $injector;
    }
    
    /**
     * Get the request object
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->_request;
    }
    
    /**
     * Get the response object
     * 
     * @return Response
     */
    public function getResponse()
    {
        return $this->_response;
    }
    
    /**
     * Dispatch controllers
     * 
     * @param string $rootController The first controller to dispatch
     * @return Dispatcher
     */
    public function dispatch($rootController = self::DEFAULT_ROOT_CONTROLLER)
    {
        $controller = $this->_injector->create($rootController);
        
        if (!$controller instanceof \galanthus\controller\ControllerInterface) {
            throw new DispatcherException('The requested controller must implement ControllerInterface');
        }
        
        $controller->setRequest($this->_request)
                   ->setResponse($this->_response)
                   ->forward()
                   ->execute();
        
        return $this;
    }
    
    /**
     * Output the response
     * 
     * @return string
     */
    public function output()
    {
        $this->getResponse()->output();
    }
    
}