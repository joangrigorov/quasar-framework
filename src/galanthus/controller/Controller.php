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

use galanthus\dispatcher\ResponseInterface,
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
     * GET parameters map
     * 
     * @var array
     */
    protected $_paramsMap = array();
    
    /**
     * Assigned GET parameters
     * 
     * @var array
     */
    protected $_params = array();
    
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
     * Dependency Injection container
     * 
     * @var Container
     */
    protected $_injector;
    
    /**
     * The previous controller in the chain
     * 
     * @var ControllerInterface
     */
    protected $_previous;
    
    /**
     * Sets the dependency injection container instance
     * 
     * @param Container $injector
     */
    public function __construct(Container $injector)
    {
        $this->_injector = $injector;
        $this->_params = $this->_paramsMap;
    }
    
    /**
     * Sets the request object
     * 
     * @param RequestInterface $request
     * @return Controller
     */
    public function setRequest(RequestInterface $request)
    {
        $this->_request = $request;
        return $this;
    }
    
    /**
     * Retrieve the request object
     * 
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->_request;
    }
    
    /**
     * Sets the response object
     * 
     * @param ResponseInterface $response
     * @return Controller
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->_response = $response;
        return $this;
    }
    
    /**
     * Retrieve the response object
     *
     * @return RequestInterface
     */
    public function getResponse()
    {
        return $this->_response;
    }
    
    /**
     * Sets the previous controller
     * 
     * @param ControllerInterface $controller
     * @return Controller
     */
    public function setPrevious(ControllerInterface $controller)
    {
        $this->_previous = $controller;
        return $this;
    }
    
    /**
     * Gets the previous controller
     * 
     * @return ControllerInterface
     */
    public function getPrevious()
    {
        return $this->_previous;
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
    protected function _getNamespace()
    {
        $reflection = new \ReflectionClass(get_class($this));
        return $reflection->getNamespaceName();
    }
    
    /**
     * Map paramters from the query
     * 
     * @param Query $query
     * @return boolean
     */
    protected function _mapParams()
    {
        $query = $this->getQuery();
        $paramsMapped = false;
        $query->rewind();
        foreach ($query as $key => $param) {
            
            if ($key&1) {
                continue;
            }
            
            if (array_key_exists($param, $this->_paramsMap)) {
                $query->next();
                $this->_params[$param] = $query->current();
                $paramsMapped = true;
            }
        }
        
        return $paramsMapped;
    }
    
    /**
     * Get param
     * 
     * @param string $param
     * @param mixed $defaultValue
     * @return mixed
     */
    protected function _getParam($param, $defaultValue = null)
    {
        if (array_key_exists($param, $this->_params)) {
            return $this->_params[$param];
        } else {
            return $defaultValue;
        }
    }
    
    /**
     * Custom functionality before forwarding
     */
    protected function _hook()
    {
    }
    
    public function forward()
    {
        $query = $this->getQuery();
        
        // invoke the forward hook
        $this->_hook();
        
        $paramsMapped = $this->_mapParams($query);
        
        if (!count($query) || $paramsMapped) {
            return $this;
        }
        
        $next = $query->shift();
        
        /* @var $controller Controller */
        $controller = $this->_injector->create($this->_getNamespace() . '\\' . ucfirst($next));
        $controller->setRequest($this->getRequest())
                   ->setResponse($this->getResponse())
                   ->setPrevious($this);
        
        
        return $controller->forward($query);
    }
    
}