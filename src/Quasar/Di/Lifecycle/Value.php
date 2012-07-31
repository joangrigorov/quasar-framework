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
class Value implements LifecycleInterface
{
    
    /**
     * Class name
     *
     * @var string
     */
    protected $class;
    
    /**
     * Class instance
     *
     * @var string
     */
    protected $instance;
    
    /**
     * Constructor
     * 
     * Sets instance
     *
     * @param mixed $instance
     */
    public function __construct($instance)
    {
        $this->instance = $instance;
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
     * Get instance
     * 
     * @param array $dependencies
     * @return mixed
     */
    public function instantiate($dependencies)
    {
        return $this->instance;
    }
    
    /**
     * Setters should always be invoked when using this factory
     *
     * @return boolean
     */
    public function shouldInvokeSetters()
    {
        return true;
    }
}