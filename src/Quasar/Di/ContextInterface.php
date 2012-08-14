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

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com *
 * @category   Quasar
 * @package    Quasar Dependency Injection
 * @copyright  Copyright (c) 2012 Sasquatch
 */
interface ContextInterface
{
    
    /**
     * Will use condition
     *
     * @param mixed $preference
     * @return void
     */
    public function willUse($preference);
    
    /**
     * Conditions for a variable
     *
     * @param string $name
     * @return Variable
     */
    public function forVariable($name);

    /**
     * Get context when creating instance
     *
     * @param string $type
     * @return ContextInterface
     */
    public function whenCreating($type);

    /**
     * Get context for type
     *
     * @param string $type
     * @return Type
     */
    public function forType($type);

    /**
     * Get class repository
     *
     * @return ClassRepository
     */
    public function getRepository();

    /**
     * Choose factory class
     *
     * @param string $type 
     * @param array $candidates
     * @return 
     */
    public function pickFactory($type, $candidates);
    
    /**
     * Get setter methods for the given class
     *
     * @param string $class
     * @return array
     */
    public function settersFor($class);
    
    /**
     * Instantiate parameter
     *
     * @param \ReflectionParameter $parameter
     * @param array $nesting
     * @return mixed
     */
    public function instantiateParameter(\ReflectionParameter $parameter, $nesting);
    
    /**
     * Get the dependency injection container instance
     * 
     * @return Container
     */
    public function getContainer();
    
}