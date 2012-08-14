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
 * @package    Quasar Controller
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Controller\Helper;

use Quasar\Dispatcher\Response\Decorator\Renderer as RendererDecorator,
    Quasar\Controller\Helper\AbstractHelper;

/**
 * Helper for quick renderer settings
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Controller
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Renderer extends AbstractHelper
{
    
    /**
     * Set view renderer script
     * 
     * @param string $script View script name to set
     * @return Renderer
     */
    public function direct($script = null)
    {
        if (null !== $script) {
            $scriptParamName = RendererDecorator::RESERVED_SCRIPT_PARAM_NAME;
            $this->response->setInstruction($scriptParamName, $script);
        }
        
        return $this;
    }
    
    /**
     * Disable view renderer
     * 
     * @return Renderer
     */
    public function disable()
    {
        $statusParamName = RendererDecorator::RESERVED_RENDERER_STATUS;
        $this->response->setInstruction($statusParamName, false);
        return $this;
    }
    
    /**
     * Enable view renderer
     * 
     * @return Renderer
     */
    public function enable()
    {
        $statusParamName = RendererDecorator::RESERVED_RENDERER_STATUS;
        $this->response->setInstruction($statusParamName, true);
        return $this;
    }
    
}