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
 * @package    Galanthus Dependency Injection
 * @subpackage Lifecycle
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\di\lifecycle;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dependency Injection
 * @subpackage Lifecycle
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Shared implements LifecycleInterface
{
    
    /**
     * Class name
     *
     * @var string
     */
    protected $_class;
    
    /**
     * Single instance
     *
     * @var string
     */
    protected $_instance = null;
    
    /**
     * Number of instantiation
     * 
     * @var integer
     */
    protected $_timesInstiantiated = 0;
    
    /**
     * Constructor
     * 
     * Sets class name
     *
     * @param string $class
     */
    public function __construct($class)
    {
        $this->_class = $class;
    }
    
    /**
     * Return class name
     * 
     * @return string
     */
    public function getClass()
    {
        return $this->_class;
    }
    
    /**
     * Check if this class fit
     *
     * @param array $candidates
     * @return boolean
     */
    public function isOneOf($candidates)
    {
        return in_array($this->_class, $candidates);
    }

    /**
     * Create/get instance
     *
     * @param array $dependencies
     * @return mixed
     */
    public function instantiate($dependencies)
    {
        $this->_timesInstiantiated++;
        
        if (null == $this->_instance) {
            $this->_instance = call_user_func_array(
                array(
                    new \ReflectionClass($this->_class), 'newInstance'
                ), 
                $dependencies
            );
        }
        return $this->_instance;
    }
    
    /**
     * Invoke setters only on the first instantiation
     *
     * @return boolean
     */
    public function shouldInvokeSetters()
    {
        if (1 < $this->_timesInstiantiated) {
            return false;
        }
        
        return true;
    }
}