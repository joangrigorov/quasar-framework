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
class IncomingParameters
{

    /**
     * Injector instance itself
     * 
     * @var ContextInterface
     */
    protected $_injector;

    /**
     * Parameter names
     * 
     * @var array
     */
    protected $_names = null;
    
    /**
     * Constructor
     * 
     * Sets parameters names and injector instance
     * 
     * @param array $names
     * @param ContextInterface $injector
     */
    public function __construct(array $names = array(), ContextInterface $injector)
    {
        $this->_names = $names;
        $this->_injector = $injector;
    }
    
    /**
     * Gets injector instance
     * 
     * @return ContextInterface
     */
    public function getInjector()
    {
        return $this->_injector;
    }

    /**
     * Fill parameter placeholders with values
     * 
     * @return ContextInterface
     */
    public function with()
    {
        $values = func_get_args();
        $this->getInjector()->useParameters(array_combine($this->names, $values));
        return $this->_injector;
    }
}