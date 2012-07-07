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

use galanthus\dispatcher\response\decorators\Layout as LayoutDecorator,
    galanthus\controller\HelperAbstract;

/**
 * Helper for quick layout settings
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Controller
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Layout extends HelperAbstract
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
            $this->response->{$scriptParamName} = $script;
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
        $this->response->{$statusParamName} = false;
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
        $this->response->{$statusParamName} = true;
        return $this;
    }
    
}