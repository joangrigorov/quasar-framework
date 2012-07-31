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

use Quasar\Dispatcher\Request\Query;

/**
 * The standard request object
 * 
 * Resolves the requested URI
 * 
 * @todo Customizing route
 * 
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch
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
            return isset($_GET[(string) $param]) ? $_GET[(string) $param] : $defaultValue;
        }
    }
    
    /**
     * Set response parameters
     *
     * @param array $params
     * @return Request
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }
    
    /**
     * Get response parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * Clear response parameters
     *
     * @return Request
     */
    public function clearParams()
    {
        $this->params = array();
        return $this;
    }
    
    /**
     * Add request parameters
     * 
     * @param array $params
     * @return Request
     */
    protected function addParams(array $params)
    {
        foreach ($params as $name => $value) {
            $this->setParam($name, $value);
        }
        return $this;
    }
    
    /**
     * Map paramters from the query
     * 
     * @param array $paramsMap Parameters to map
     * @return boolean
     */
    public function mapParams(array $paramsMap)
    {
        $this->addParams($paramsMap);
        
        $query = $this->getQuery();
        $paramsMapped = false;
        $query->rewind();
        foreach ($query as $key => $param) {
            
            if ($key&1) {
                continue;
            }
            
            if (array_key_exists($param, $paramsMap)) {
                $query->next();
                $this->params[$param] = urldecode($query->current());
                $paramsMapped = true;
            }
        }
        
        return $paramsMapped;
    }

    /**
     * Set POST values
     *
     * @param  string|array $spec
     * @param  null|mixed $value
     * @throws RequestException When invalid value is passed
     * @return Request
     */
    public function setPost($spec, $value = null)
    {
        if ((null === $value) && !is_array($spec)) {
            require_once 'Zend/Controller/Exception.php';
            throw new RequestException('Invalid value passed to setPost(); must be either array of values or key/value pair');
        }
        if ((null === $value) && is_array($spec)) {
            foreach ($spec as $key => $value) {
                $this->setPost($key, $value);
            }
            return $this;
        }
        $_POST[(string) $spec] = $value;
        return $this;
    }

    /**
     * Retrieve a member of the $_POST superglobal
     *
     * If no $key is passed, returns the entire $_POST array.
     *
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed Returns null if key does not exist
     */
    public function getPost($key = null, $default = null)
    {
        if (null === $key) {
            return $_POST;
        }

        return (isset($_POST[(string) $key])) ? $_POST[(string) $key] : $default;
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