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
    galanthus\dispatcher\RequestInterface;

/**
 * Helpers abstract class
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Controller
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
abstract class HelperAbstract implements HelperInterface
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
     * Set the request object
     *
     * @param RequestInterface $request
     * @return HelperAbstract
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }
    
    /**
     * Get the request object
     *
     * @return RequestInterface
    */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * Set the response object
     *
     * @param ResponseInterface $response
     * @return HelperAbstract
    */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }
    
    /**
     * Get the response object
     *
     * @return ResponseInterface
    */
    public function getResponse()
    {
        return $this->response;
    }
    
}