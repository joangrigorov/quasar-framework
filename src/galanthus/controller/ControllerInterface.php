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

use galanthus\dispatcher\request\Query,
    galanthus\dispatcher\ResponseInterface,
    galanthus\dispatcher\RequestInterface;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Controller
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
interface ControllerInterface
{
    
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
     * Find the next controller
     * 
     * @param Query $query
     * @return ControllerInterface
     */
    public function forward(Query $query);
    
    /**
     * Execute action controller
     */
    public function execute();
}