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
 * @subpackage Response
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\dispatcher\response\decorators;

use galanthus\view\Renderer as StandardRenderer,
    galanthus\view\RendererInterface,
    galanthus\dispatcher\ResponseInterface,
    galanthus\dispatcher\response\DecoratorAbstract;


/**
 * Response decorator for the view renderer
 * 
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dispatcher
 * @subpackage Response
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Layout extends DecoratorAbstract
{
    
    const DEFAULT_SUFFIX = 'phtml';
    
   /**@#+
    * Reserved response param names
    */
    const RESERVED_SCRIPT_PARAM_NAME = '_layout';
    const RESERVED_LAYOUT_STATUS = '_layoutEnabled';
    /**@#-*/
    
    /**
     * The default renderer object
     * 
     * @var RendererInterface
     */
    protected $renderer;
    
    /**
     * View scripts default suffix
     * 
     * @var string
     */
    protected $suffix = self::DEFAULT_SUFFIX;
    
    /**
     * Layout parameters
     * 
     * @var array
     */
    protected $params = array();
    
    /**
     * Constructor
     * 
     * Sets dependencies
     * 
     * @param StandardRenderer $viewRenderer
     */
    public function __construct(StandardRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Set the renderer instance
     * 
     * @param RendererInterface $renderer
     * @return Renderer
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
    
    /**
     * Get the renderer instance
     * 
     * @return RendererInterface
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * Set view scripts suffix
     * 
     * @param string $suffix
     * @return Renderer
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
        return $this;
    }
    
    /**
     * Get view scripts suffix
     * 
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }
    
    /**
     * Set layout parameters
     * 
     * @param array $params
     * @return Layout
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Get layout parameters
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * Decorate response
     *
     * @param $content string
     * @return string
     */
    public function decorate($content)
    {
        $layout = $this->response->getInstruction(self::RESERVED_SCRIPT_PARAM_NAME);
        $isEnabled = $this->response->getInstruction(self::RESERVED_LAYOUT_STATUS, true);
        
        if (!$isEnabled) {
            return $content;
        }
        
        $viewScript = $layout . '.' . $this->suffix;

        $responseParameters = $this->response->getParams();
        $params = array_merge($this->params, $responseParameters);
        
        return $this->renderer
                    ->setParams($params)
                    ->setParam('content', $content)
                    ->render($viewScript);
    }
    
}