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
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\View\Helper;

use Quasar\View\Helper\HelperException,
    Quasar\View\Helper\AbstractHelper;

/**
 * View helper for rendering partial view scripts
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar View
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Partial extends AbstractHelper
{

    /**
     * Renderers view script
     * 
     * @param string $script
     * @param array $params
     * @return string
     * @throws HelperException When $script is not string
     */
    public function direct()
    {
        if (!func_num_args()) {
            return null;
        }
        
        $arguments = func_get_args();
                
        $renderer = clone $this->renderer;
        $renderer->clearParams();
        
        if (!is_string($arguments[0])) {
            throw new HelperException('View script path must be string');
        }
        
        if (isset($arguments[1]) && is_array($arguments[1])) {
            $renderer->setParams($arguments[1]);
        }
        
        return $renderer->render($arguments[0]);
    }
    
}