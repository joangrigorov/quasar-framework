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
 * @package    Galanthus Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\dispatcher;

use galanthus\di\Container;

/**
 * The standard dispatcher object
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Dispatcher implements DispatcherInterface
{
    
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
     * The dependency injection container
     * 
     * @var Container
     */
    protected $injector;
    
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
        $this->request = $request;
        $this->response = $response;
        $this->injector = $injector;
    }
    
    /**
     * Get the request object
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * Get the response object
     * 
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * Dispatch controllers
     * 
     * @param string $rootController The first controller to dispatch
     * @return Dispatcher
     */
    public function dispatch($rootController = self::DEFAULT_ROOT_CONTROLLER)
    {
        $controller = $this->injector->create($rootController);
        
        if (!$controller instanceof \galanthus\controller\ControllerInterface) {
            throw new DispatcherException('The requested controller must implement ControllerInterface');
        }
        
        $controller->setRequest($this->request)
                   ->setResponse($this->response)
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
        return $this->getResponse()->output();
    }
    
}