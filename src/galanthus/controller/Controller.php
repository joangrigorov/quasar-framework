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