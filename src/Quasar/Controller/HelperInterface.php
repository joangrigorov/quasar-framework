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

namespace Quasar\Controller;

use Quasar\Dispatcher\ResponseInterface,
    Quasar\Dispatcher\RequestInterface,
    Quasar\Broker\HelperInterface as GlobalHelperInterface;

/**
 * Helpers interface
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Controller
 * @copyright  Copyright (c) 2012 Sasquatch
 */
interface HelperInterface extends GlobalHelperInterface
{
    
    /**
     * Set the request object
     * 
     * @param RequestInterface $request
     * @return HelperInterface
     */
    public function setRequest(RequestInterface $request);
    
    /**
     * Get the request object
     * 
     * @return RequestInterface
     */
    public function getRequest();
    
    /**
     * Set the response object
     * 
     * @param ResponseInterface $response
     * @return HelperInterface
     */
    public function setResponse(ResponseInterface $response);

    /**
     * Get the response object
     *
     * @return ResponseInterface
     */
    public function getResponse();
    
}