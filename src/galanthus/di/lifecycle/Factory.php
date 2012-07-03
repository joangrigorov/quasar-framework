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
class Factory implements LifecycleInterface
{
    
    /**
     * Class name
     *
     * @var string
     */
    protected $class;
    
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
     * Get instance
     *
     * @param array $dependencies
     * @return mixed
     */
    public function instantiate($dependencies)
    {
        return call_user_func_array(
            array(
                new \ReflectionClass($this->class), 'newInstance'
            ), $dependencies
        );
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