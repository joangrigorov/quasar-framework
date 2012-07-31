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
 * @package    Quasar Dependency Injection
 * @subpackage Lifecycle
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Di\Lifecycle;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Dependency Injection
 * @subpackage Lifecycle
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Shared implements LifecycleInterface
{
    
    /**
     * Class name
     *
     * @var string
     */
    protected $class;
    
    /**
     * Single instance
     *
     * @var string
     */
    protected $instance = null;
    
    /**
     * Number of instantiation
     * 
     * @var integer
     */
    protected $timesInstiantiated = 0;
    
    /**
     * Constructor
     * 
     * Sets class name
     *
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }
    
    /**
     * Return class name
     * 
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
    
    /**
     * Check if this class fit
     *
     * @param array $candidates
     * @return boolean
     */
    public function isOneOf($candidates)
    {
        return in_array($this->class, $candidates);
    }

    /**
     * Create/get instance
     *
     * @param array $dependencies
     * @return mixed
     */
    public function instantiate($dependencies)
    {
        $this->timesInstiantiated++;
        
        if (null == $this->instance) {
            $this->instance = call_user_func_array(
                array(
                    new \ReflectionClass($this->class), 'newInstance'
                ), 
                $dependencies
            );
        }
        return $this->instance;
    }
    
    /**
     * Invoke setters only on the first instantiation
     *
     * @return boolean
     */
    public function shouldInvokeSetters()
    {
        if (1 < $this->timesInstiantiated) {
            return false;
        }
        
        return true;
    }
}