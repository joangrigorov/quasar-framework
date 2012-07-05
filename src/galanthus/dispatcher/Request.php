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

use galanthus\dispatcher\request\Query;

/**
 * The standard request object
 * 
 * Resolves the requested URI
 * 
 * @todo Customizing route
 * 
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Request implements RequestInterface
{
    
    /**
     * Query queue
     * 
     * @var Query
     */
    protected $query;
    
    /**
     * Request parameters
     * 
     * @var array
     */
    protected $params = array();
    
    /**
     * Sets the request query queue object
     * 
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
        $this->resolveUri();
    }
    
    /**
     * Parse URI and construct the Query queue object
     */
    protected function resolveUri()
    {

        if (dirname($_SERVER['SCRIPT_NAME']) != DS) {
            $requestQuery = parse_url(
                str_replace(dirname($_SERVER['SCRIPT_NAME']), '', 
                        str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI'])
                )
            );
        } else {
            $requestQuery = parse_url(
                str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI'])
            );
        }
        
        $path = explode('/', $requestQuery['path']);
        
        if (!empty($path)) {
            foreach ($path as $entity) {
                if (empty($entity)) {
                    continue;
                }
                $this->query->push($entity);
            }
        }        
    }
    
    /**
     * Set request parameter
     * 
     * @param string $name
     * @param mixed $value
     * @return Request
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }
    
    /**
     * Get request parameter
     * 
     * @param string $param
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getParam($param, $defaultValue = null)
    {
        if (array_key_exists($param, $this->params)) {
            return $this->params[$param];
        } else {
            return $defaultValue;
        }
    }
    
    /**
     * Map paramters from the query
     * 
     * @param array $paramsMap Parameters to map
     * @return boolean
     */
    public function mapParams(array $paramsMap)
    {
        $query = $this->getQuery();
        $paramsMapped = false;
        $query->rewind();
        foreach ($query as $key => $param) {
            
            if ($key&1) {
                continue;
            }
            
            if (array_key_exists($param, $paramsMap)) {
                $query->next();
                $this->params[$param] = $query->current();
                $paramsMapped = true;
            }
        }
        
        return $paramsMapped;
    }
    
    /**
     * Get the query queue
     * 
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }
    
}