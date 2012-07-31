<?php
/**
 * Quasar Framework © 2012
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
 * @category   Quasar
 * @package    Quasar Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Dispatcher;

use Quasar\Broker\HelperBroker,
    Quasar\Di\Container;

/**
 * The standard dispatcher object
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch
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
     * Broker for controller helpers
     * 
     * @var \Quasar\Broker\HelperBrokerInterface
     */
    protected $helperBroker;
    
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
     * @param Request $request The request object
     * @param Response $response The response object
     * @param Container $injector Dependency Injection cotainer
     * @param HelperBroker $helperBroker Controller helper's broker
     */
    public function __construct(Request $request, 
                                Response $response, 
                                Container $injector,
                                HelperBroker $helperBroker)
    {
        $this->request = $request;
        $this->response = $response;
        $this->injector = $injector;
        $this->helperBroker = $helperBroker;
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
     * Get controller helper's broker
     * 
     * @return \Quasar\Broker\HelperBrokerInterface
     */
    public function getHelperBroker()
    {
        return $this->helperBroker;
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
        
        if (!$controller instanceof \Quasar\Controller\ControllerInterface) {
            throw new DispatcherException('The requested controller must implement ControllerInterface');
        }
        
        $controller->setRequest($this->request)
                   ->setResponse($this->response)
                   ->setHelperBroker($this->helperBroker)
                   ->setInjector($this->injector)
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