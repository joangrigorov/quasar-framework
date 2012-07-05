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

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
interface RequestInterface
{
    
    /**
     * Get the request query object
     * 
     * @return \galanthus\dispatcher\request\Query
     */
    public function getQuery();
    
    /**
     * Map paramters from the query
     * 
     * @param array $paramsMap Parameters to map
     * @return boolean
     */
    public function mapParams(array $paramsMap);
    
    /**
     * Set request parameter
     * 
     * @param string $name
     * @param mixed $value
     * @return Request
     */
    public function setParam($name, $value);
    
    /**
     * Get param
     * 
     * @param string $param
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getParam($param, $defaultValue = null);
    
}