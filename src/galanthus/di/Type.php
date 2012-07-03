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
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\di;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dependency Injection
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Type
{

    /**
     * Setter method
     * 
     * Will be called automatically when instantiating
     * 
     * @var array
     */
    protected $setters = array();
    
    /**
     * Get setter methods
     * 
     * @return array
     */
    public function getSetters()
    {
        return $this->setters;
    }
    
    /**
     * Sets setter method
     * 
     * @param string $method
     * @return Type
     */
    public function call($method)
    {
        array_unshift($this->setters, $method);
        return $this;
    }
}