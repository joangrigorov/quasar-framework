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

namespace galanthus\dispatcher\response;

use galanthus\dispatcher\ResponseInterface;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Controller
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
interface DecoratorInterface
{
    
    /**
     * Sets the response object
     * 
     * @param ResponseInterface $response
     * @return DecoratorInterface
     */
    public function setResponse(ResponseInterface $response);
       
    /**
     * Get the response object
     * 
     * @return ResponseInterface
     */
    public function getResponse();
    
    
    /**
     * Decorate content
     * 
     * @param string $content
     * @return DecoratorInterface
     */
    public function decorate($content);
    
}