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
 * @package    Galanthus Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\dispatcher;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
interface ResponseInterface
{
    
    /**
     * Set response parameters
     * 
     * @param array $params
     * @return ResponseInterface
     */
    public function setParams(array $params);
    
    /**
     * Get response parameters
     * 
     * @return array
     */
    public function getParams();
    
    /**
     * Set response parameter
     * 
     * @param string $name
     * @param mixed $value
     * @return ResponseInterface
     */
    public function setParam($name, $value);
    
    /**
     * Get response parameter
     * 
     * @param string $name
     * @return mixed
     */
    public function getParam($name);
    
    /**
     * Clear response parameters
     * 
     * @return ResponseInterface
     */
    public function clearParams();
        
    /**
     * Set action decorators
     *
     * @param array $decorators Array of decorators with options
     * @return ResponseInterface
     */
    public function setDecorators(Array $decorators);
    
    /**
     * Get registered decorators
     *
     * @return array
     */
    public function getDecorators();
    
    /**
     * Add decorator with options
     *
     * @param string|\galanthus\dispatcher\response\DecoratorInterface $decorator Decorator name
     *                                                            or decorator object itself
     * @param mixed $options Options to set to the decorator.
     *                       Can be an array object with toArray method.
     * @return ResponseInterface
     */
    public function addDecorator($decorator, $options = null);
    
    /**
     * Add many decorators at once
     *
     * @param  array $decorators
     * @return ResponseInterface
     */
    public function addDecorators(Array $decorators);
    
    /**
     * Remove single decorator
     *
     * @param string $decorator
     * @return ResponseInterface
     */
    public function removeDecorator($decorator);
    
    /**
     * Remove all registered decorators
     *
     * @return ResponseInterface
     */
    public function clearDecorators();
    
    /**
     * Get decorated output
     * 
     * @return string
     */
    public function output();
    
}