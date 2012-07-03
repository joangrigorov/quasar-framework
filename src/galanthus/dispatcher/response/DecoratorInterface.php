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
 * @subpackage Response
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\dispatcher\response;

use galanthus\dispatcher\ResponseInterface;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dispatcher
 * @subpackage Response
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
interface DecoratorInterface
{
    
    /**@#+
     * Placement constants
    */
    const APPEND  = 'APPEND';
    const PREPEND = 'PREPEND';
    /**@#-*/
    
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
     * Sets content placement
     *
     * @param string $placement
     * @return DecoratorInterface
     */
    public function setPlacement($placement);
    
    /**
     * Get content placement
     *
     * @return string
     */
    public function getPlacement();
    
    /**
     * Set decorator options
     * 
     * @param array $options
     * @return DecoratorInterface
     */
    public function setOptions(array $options);
    
    /**
     * Decorate content
     * 
     * @param string $content
     * @return string
     */
    public function decorate($content);
    
}