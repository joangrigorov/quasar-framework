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

namespace Quasar\View\Helper;

use Quasar\View\Renderer\RendererInterface;

/**
 * View helpers abstract class
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar View
 * @copyright  Copyright (c) 2012 Sasquatch
 */
abstract class AbstractHelper implements HelperInterface
{
    
    /**
     * View renderer instance
     * 
     * @var RendererInterface
     */
    protected $renderer;
    
    /**
     * Set view renderer instance
     * 
     * @param RendererInterface $renderer
     * @return AbstractHelper
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
    
    /**
     * Get view renderer instance
     * 
     * @return RendererInterface
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

}