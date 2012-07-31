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
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Di;

use Quasar\Di\Lifecycle\LifecycleInterface,
    Quasar\Di\Lifecycle\Value;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Dependency Injection
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Variable
{
    
    /**
     * Preference factory
     * 
     * @var LifecycleInterface
     */
    protected $preference;

    /**
     * 
     * @var ContextInterface
     */
    protected $context;

    /**
     * Constructor
     * 
     * Sets context
     * 
     * @param ContextInterface $context
     */
    public function __construct(ContextInterface $context)
    {
        $this->context = $context;
    }
    
    /**
     * Gets preference
     * 
     * @return LifecycleInterface
     */
    public function getPreference()
    {
        return $this->preference;
    }

    /**
     * Object that will be used as a value
     * 
     * @param mixed $preference
     * @return ContextInterface
     */
    public function willUse($preference)
    {
        $this->preference = $preference;
        return $this->context;
    }

    /**
     * Use value
     * 
     * @param string $string
     * @return ContextInterface
     */
    public function useString($string)
    {
        $this->preference = new Value($string);
        return $this->context;
    }
}