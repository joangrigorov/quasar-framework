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
interface LifecycleInterface
{
    
    /**
     * Return class name
     * 
     * @return string
     */
    public function getClass();
    
    /**
     * Check if this class fit
     * 
     * @param array $candidates
     * @return boolean
     */
    public function isOneOf($candidates);

    /**
     * Instantiate class
     * 
     * @param string $dependencies
     * @return mixed
     */
    public function instantiate($dependencies);
    
    /**
     * Return TRUE if the container should invoke setter 
     * on the relevant class
     * 
     * @return boolean
     */
    public function shouldInvokeSetters();
    
}