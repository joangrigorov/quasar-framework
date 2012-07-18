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
    galanthus\dispatcher\request\Query,
    galanthus\dispatcher\ResponseInterface,
    galanthus\dispatcher\RequestInterface,
    galanthus\di\Container;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Controller
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
interface ControllerInterface
{
    
    /**
     * Set the dependency injection container instance
     * 
     * @param Container $injector
     * @return ControllerInterface
     */
    public function setInjector(Container $injector);
    
    /**
     * Get the dependency injection container instance
     * 
     * @return Container
     */
    public function getInjector();
    
    /**
     * Sets the request object
     * 
     * @param RequestInterface $request
     * @return ControllerInterface
     */
    public function setRequest(RequestInterface $request);
    
    /**
     * Retrieve the request object
     * 
     * @return RequestInterface
     */
    public function getRequest();
    
    /**
     * Sets the response object
     * 
     * @param ResponseInterface $response
     * @return ControllerInterface
     */
    public function setResponse(ResponseInterface $response);
    
    /**
     * Retrieve the response object
     * 
     * @return ResponseInterface
     */
    public function getResponse();
    
    /**
     * Set broker for controller helpers
     * 
     * @param HelperBrokerInterface $helperBroker
     * @return ControllerInterface
     */
    public function setHelperBroker(HelperBrokerInterface $helperBroker);
    
    /**
     * Get the broker for controller helpers
     * 
     * @return HelperBrokerInterface
     */
    public function getHelperBroker();
    
    /**
     * Find the next controller
     * 
     * @param Query $query
     * @return ControllerInterface
     */
    public function forward();
    
    /**
     * Execute action controller
     */
    public function execute();
}