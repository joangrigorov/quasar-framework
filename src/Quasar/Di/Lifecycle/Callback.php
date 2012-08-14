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

use Quasar\Di\DiException;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Dependency Injection
 * @subpackage Lifecycle
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Callback implements LifecycleInterface
{
    
    /**
     * The callback function
     * 
     * @var callable
     */
    protected $callback;
    
    /**
     * Constructor
     * 
     * Sets the callback function
     * 
     * @param callable $callback
     */
    public function __construct($callback)
    {
        $this->callback = $callback;
    }
    
    /**
     * Return class name
     * 
     * @return string
     */
    public function getClass()
    {
        return null;
    }
    
    /**
     * Check if this class fit
     *
     * @param array $candidates
     * @return boolean
     */
    public function isOneOf($candidates)
    {
        return false;
    }
    
    /**
     * Get instance
     *
     * @param Quasar\Di\ContextInterface $dependencies
     * @return mixed
     */
    public function instantiate($context)
    {
        if (!$context instanceof \Quasar\Di\ContextInterface) {
            throw new DiException('$context must be a ContextInterface instance');
        }
        
        $injector = $context->getContainer();
        
        $callback = $this->callback;
        
        return $callback($injector, $context);
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