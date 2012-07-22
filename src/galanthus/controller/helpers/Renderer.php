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
 * @package    Galanthus Controller
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\controller\helpers;

use galanthus\dispatcher\response\decorators\Renderer as RendererDecorator,
    galanthus\controller\HelperAbstract;

/**
 * Helper for quick renderer settings
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Controller
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Renderer extends HelperAbstract
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