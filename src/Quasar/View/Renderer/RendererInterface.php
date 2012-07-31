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
 * @package    Quasar View
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\View\Renderer;

/**
 * View renderer interface
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar View
 * @copyright  Copyright (c) 2012 Sasquatch
 */
interface RendererInterface
{
    
    /**
     * Add view script path
     * 
     * @param string $path
     * @return RendererInterface
     */
    public function addScriptPath($path);
    
    /**
     * Set view script path
     * 
     * @param array $paths
     * @return RendererInterface
     */
    public function setScriptPaths(array $paths);
    
    /**
     * Set parameters
     * 
     * @param array $params
     * @return RendererInterface
     */
    public function setParams(array $params);
    
    /**
     * Get parameters
     * 
     * @return array
     */
    public function getParams();
    
    /**
     * Set parameter
     * 
     * @param string $name
     * @param mixed $value
     * @return RendererInterface
     */
    public function setParam($name, $value);
    
    /**
     * Get parameter
     * 
     * @param string $name
     * @return mixed
     */
    public function getParam($name);
    
    /**
     * Clear parameters
     * 
     * @return RendererInterface
     */
    public function clearParams();
    
    /**
     * Render view script
     * 
     * @param string $script
     * @return string
     */
    public function render($script);
    
    /**
     * Escape string content
     * 
     * Prevents XSS attacks
     * 
     * @param string $string
     * @return string
     */
    public function escape($string);
    
}