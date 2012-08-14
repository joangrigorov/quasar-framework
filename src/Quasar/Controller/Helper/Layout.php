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

use Quasar\Dispatcher\Response\Decorator\Layout as LayoutDecorator,
    Quasar\Controller\Helper\AbstractHelper;

/**
 * Helper for quick layout settings
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Controller
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Layout extends AbstractHelper
{
    
    /**
     * Set layout script
     * 
     * @param string $script Layout script name to set
     * @return Layout
     */
    public function direct($script = null)
    {
        if (null !== $script) {
            $scriptParamName = LayoutDecorator::RESERVED_SCRIPT_PARAM_NAME;
            $this->response->setInstruction($scriptParamName, $script);
        }
        
        return $this;
    }
    
    /**
     * Disable layout
     * 
     * @return Layout
     */
    public function disable()
    {
        $statusParamName = LayoutDecorator::RESERVED_LAYOUT_STATUS;
        $this->response->setInstruction($statusParamName, false);
        return $this;
    }
    
    /**
     * Enable layout
     * 
     * @return Layout
     */
    public function enable()
    {
        $statusParamName = LayoutDecorator::RESERVED_LAYOUT_STATUS;
        $this->response->setInstruction($statusParamName, true);
        return $this;
    }
    
}