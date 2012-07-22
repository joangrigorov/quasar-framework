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
     * Response decorators default namespace
     * 
     * @var string
     */
    const DECORATORS_NAMESPACE = 'galanthus\dispatcher\response\decorators\\';
    
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
     * @param mixed $defaultValue
     * @return mixed|null
     */
    public function getParam($name, $defaultValue = null);
    
    /**
     * Clear response parameters
     * 
     * @return ResponseInterface
     */
    public function clearParams();


    /**
     * Set response instructions
     *
     * @param array $instructions
     * @return Response
     */
    public function setInstructions(array $instructions);
    
    /**
     * Get response instructions
     *
     * @return array
     */
    public function getInstructions();
    
    /**
     * Set instruction
     *
     * @param string $name
     * @param mixed $value
     * @return Response
     */
    public function setInstruction($name, $value);
    
    /**
     * Get instructions
     *
     * @param string $name
     * @param mixed $defaultValue
     * @return mixed|null
     */
    public function getInstruction($name, $defaultValue = null);
    
    /**
     * Clear instructions
     *
     * @return Response
     */
    public function clearInstructions();
    
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
     * Check if a decorator is set
     * 
     * @param string $decorator
     * @return boolean
     */
    public function hasDecorator($decorator);
    
    /**
     * Get decorator
     * 
     * @param string $decorator
     * @throws ResponseException When decorator is not found
     * @return DecoratorInterface
     */
    public function getDecorator($decorator);
    
    /**
     * Remove all registered decorators
     *
     * @param array $exceptions If set, it will clear all the decorators 
     *                          except the specified in this array
     * @return ResponseInterface
     */
    public function clearDecorators(array $exceptions = null);
    
    /**
     * Get decorated output
     * 
     * @return string
     */
    public function output();
    
}