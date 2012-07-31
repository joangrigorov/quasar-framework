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
 * @package    Quasar View
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\View\Renderer;

use Quasar\Broker\HelperBroker,
    Quasar\Broker\HelperBrokerInterface,
    Quasar\View\Helper\HelperInterface;

/**
 * Standard view renderer
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar View
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Renderer implements RendererInterface
{
    
    /**
     * View script paths
     * 
     * @var mutltitype:string
     */
    protected $scriptPaths = array();
    
    /**
     * View script parameters
     * 
     * @var array
     */
    protected $params = array();
    
    /**
     * Broker for view helpers
     * 
     * @var Quasar\Broker\HelperBrokerInterface
     */
    protected $helperBroker;
    
    /**
     * Constructor
     * 
     * Sets view helpers broker and view script paths
     * 
     * @param HelperBroker $helperBroker
     * @param array $paths
     */
    public function __construct(HelperBroker $helperBroker, array $paths = null)
    {
        $this->helperBroker = $helperBroker;
        
        if (null !== $paths) {
            $this->scriptPaths = $paths;
        }
    }
    
    /**
     * Add view script path
     * 
     * @param string $path
     * @return Renderer
     */
    public function addScriptPath($path)
    {
        if (!in_array($path, $this->scriptPaths)) {
            $this->scriptPaths[] = $path;
        }
        return $this;
    }
    
    /**
     * Set view script paths
     * 
     * @param array $paths
     * @return Renderer
     */
    public function setScriptPaths(array $paths)
    {
        $this->scriptPaths = $paths;
        return $this;
    }
    
    /**
     * Choose path for the requested script
     * 
     * @param string $script
     * @throws RendererException
     * @return string
     */
    protected function chooseScriptPath($script)
    {
        foreach ($this->scriptPaths as $path) {
            if (file_exists($path . DS . $script)) {
                return realpath($path . DS . $script);
            }
        }
        throw new RendererException("Script '$script' not found");
    }
    
    /**
     * Set parameters
     * 
     * @param array $params
     * @return Renderer
     */
    public function setParams(array $params)
    {
        if (is_object($params)
                && (!$params instanceof \Traversable)
                && method_exists($params, 'toArray')
        ) {
            $params = $params->toArray();
        }
        
        $this->params = $params;
        return $this;
    }
    
    /**
     * Get parameters
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * Set response parameter
     *
     * @param string $name
     * @param mixed $value
     * @return Renderer
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }
    
    /**
     * Get response parameter
     *
     * @param string $name
     * @return mixed|null
     */
    public function getParam($name)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
        return null;
    }
    
    /**
     * Clear response parameters
     *
     * @return Renderer
     */
    public function clearParams()
    {
        $this->params = array();
        return $this;
    }
    
    /**
     * Set the broker object for view helpers
     * 
     * @param HelperBrokerInterface $helperBroker
     * @return Renderer
     */
    public function setHelperBroker(HelperBrokerInterface $helperBroker)
    {
        $this->helperBroker = $helperBroker;
        return $this;
    }
    
    /**
     * Get the broker object for view helpers
     * 
     * @return HelperBrokerInterface
     */
    public function getHelperBroker()
    {
        return $this->helperBroker;
    }
    
    /**
     * Overriding: allowing property access
     * 
     * Accessing renderer parameters
     * 
     * @param string $name
     * @return mixed|NULL
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
        return null;
    }
    
    /**
     * Overriding: allowing property access
     *
     * Setting renderer parameters
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }
    
    /**
     * Overriding: calling helpers using the helper broker
     * 
     * @param string $helperName
     * @param array $params
     * @return void|mixed
     */
    public function __call($helperName, $params)
    {
        $helper = $this->helperBroker->getHelper($helperName);
        
        if (!$helper instanceof HelperInterface) {
            throw new RendererException("View helper '$helperName' doesn't implement Quasar\View\Helper\HelperInterface");
        }
        
        if (null == $helper->getRenderer()) {
            $helper->setRenderer($this);
        }
                
        return call_user_func_array(array($helper, 'direct'), $params);
    }
    
    /**
     * Render a view script
     * 
     * @param string $script
     * @return string
     */
    public function render($script)
    {
        $scriptPath = $this->chooseScriptPath($script);
        ob_start();
        include $scriptPath;
        $buffer = ob_get_clean();
        return $buffer;
    }

    /**
     * Escape string content
     *
     * Prevents XSS attacks
     *
     * @param string $string
     * @return string
     */
    public function escape($string)
    {
        return htmlspecialchars($string);
    }
    
}