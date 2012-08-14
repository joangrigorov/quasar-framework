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
 * @package    Quasar Controller
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Controller\Helper;

use Quasar\Dispatcher\Response\ResponseInterface,
    Quasar\Dispatcher\Request\RequestInterface;

/**
 * Helpers abstract class
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Controller
 * @copyright  Copyright (c) 2012 Sasquatch
 */
abstract class AbstractHelper implements HelperInterface
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
     * @return AbstractHelper
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
     * @return AbstractHelper
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