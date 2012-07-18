<?php
/**
 * Galanthus Framework © 2012
 * Copyright © 2012 Sasquatch <Joan-Alexander Grigorov>
 *                              http://bgscripts.com
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License v3
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @category   Galanthus
 * @package    Galanthus Controller
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\controller;

use galanthus\broker\HelperBrokerInterface,
    galanthus\broker\ControllerException,
    galanthus\dispatcher\ResponseInterface,
    galanthus\dispatcher\RequestInterface,
    galanthus\controller\ControllerInterface,
    galanthus\dispatcher\request\Query,
    galanthus\di\Container;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Controller
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
abstract class Controller implements ControllerInterface
{

    /**
     * Dependency Injection container
     *
     * @var Container
     */
    protected $injector;
    
    /**
     * GET parameters map
     * 
     * @var array
     */
    protected $paramsMap = array();
    
    /**
     * The request object
     * 
     * @var RequestInterface
     */
    protected $request;
    
    /**
     * The response object
     * 
     * @var ResponseInterface
     */
    protected $response;
    
    /**
     * The previous controller in the chain
     * 
     * @var ControllerInterface
     */
    protected $previous;
    
    /**
     * Broker for helpers
     * 
     * @var HelperBrokerInterface
     */
    protected $helperBroker;
    
    /**
     * Set the dependency injection container instance
     * 
     * @param Container $injector
     * @return Controller
     */
    public function setInjector(Container $injector)
    {
        $this->injector = $injector;
        return $this;
    }
    
    /**
     * Get the dependency injection container instance
     * 
     * @return Container
     */
    public function getInjector()
    {
        return $this->injector;
    }
    
    /**
     * Sets the request object
     * 
     * @param RequestInterface $request
     * @return Controller
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }
    
    /**
     * Retrieve the request object
     * 
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * Sets the response object
     * 
     * @param ResponseInterface $response
     * @return Controller
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }
    
    /**
     * Retrieve the response object
     *
     * @return RequestInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * Sets the previous controller
     * 
     * @param ControllerInterface $controller
     * @return Controller
     */
    public function setPrevious(ControllerInterface $controller)
    {
        $this->previous = $controller;
        return $this;
    }
    
    /**
     * Gets the previous controller
     * 
     * @return ControllerInterface
     */
    public function getPrevious()
    {
        return $this->previous;
    }
    
    /**
     * Set broker for controller helpers
     * 
     * @param HelperBrokerInterface $helperBroker
     * @return Controller
     */
    public function setHelperBroker(HelperBrokerInterface $helperBroker)
    {
        $this->helperBroker = $helperBroker;
        return $this;
    }
    
    /**
     * Get the broker for controller helpers
     * 
     * @return HelperBrokerInterface
     */
    public function getHelperBroker()
    {
        return $this->helperBroker;
    }
    
    /**
     * Get the request query object
     * 
     * @return Query
     */
    public function getQuery()
    {
        return $this->getRequest()->getQuery();
    }
    
    /**
     * Get namespace of the current controller
     * 
     * @return string
     */
    protected function getNamespace()
    {
        $reflection = new \ReflectionClass(get_class($this));
        return $reflection->getNamespaceName();
    }
    
    /**
     * Get request parameter
     * 
     * @param string $param
     * @param mixed $defaultValue
     * @return mixed
     */
    protected function getParam($param, $defaultValue = null)
    {
        return $this->request->getParam($param, $defaultValue);
    }
    
    /**
     * Set request parameter
     * 
     * @param string $name
     * @param mixed $value
     * @return Controller
     */
    protected function setParam($name, $value)
    {
        $this->request->setParam($name, $value);
        return $this;
    }
    
    /**
     * Custom functionality before forwarding
     */
    protected function hook()
    {
    }
    
    /**
     * This is only used with the {@see \galanthus\view\Renderer}
     */
    protected function setCurrentScript()
    {
        $className = end(explode('\\', get_class($this)));
        $currentScript = strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $className));
        $this->response->_script = $currentScript;
    }
    
    /**
     * Forward to the next controller in the query
     *
     * @param Query $query
     * @return ControllerInterface
     */
    public function forward()
    {
        $query = $this->getQuery();
        
        $this->setCurrentScript();
        
        // invoke the forward hook
        $this->hook();
                
        $paramsMapped = $this->request->mapParams($this->paramsMap);
        
        if (!count($query) || $paramsMapped) {
            return $this;
        }
        
        $next = $query->shift();
        
        /* @var $controller Controller */
        $controller = $this->injector->create($this->getNamespace() . '\\' . ucfirst($next));
        $controller->setRequest($this->getRequest())
                   ->setResponse($this->getResponse())
                   ->setHelperBroker($this->helperBroker)
                   ->setPrevious($this)
                   ->setInjector($this->injector);
        
        
        return $controller->forward($query);
    }
    
    /**
     * Overriding: calling helpers using the helper broker
     * 
     * @param string $helperName
     * @param array $params
     * @return void|mixed
     */
    public function __call($helperName, $params)
    {
        $helper = $this->helperBroker->getHelper($helperName);
        
        if (!$helper instanceof HelperInterface) {
            throw new ControllerException("Controller helper '$helperName' doesn't implement galanthus\controller\HelperInterface");
        }
        
        if (null == $helper->getRequest()) {
            $helper->setRequest($this->request);
        }
        
        if (null == $helper->getResponse()) {
            $helper->setResponse($this->response);
        }
        
        return call_user_func_array(array($helper, 'direct'), $params);
    }
    
}