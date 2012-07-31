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

use Quasar\Dispatcher\Response\Decorator\Json as JsonDecorator,
    Quasar\Controller\Helper\HelperAbstract;

/**
 * Helper for quick JSON settings
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Controller
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Json extends HelperAbstract
{
    
    /**
     * Return json encoded string
     * 
     * If no argument is passed - returns helper instance
     * 
     * @param mixed $var Variable to encode
     * @return string|Json
     */
    public function direct($var = null)
    {
        if (null !== $var) {
            return json_encode($var);
        }
        
        return $this;
    }
    
    /**
     * Enable json encoding
     * 
     * @return Layout
     */
    public function enable()
    {
        $this->response->clearDecorators()
                       ->addDecorator('Json')
                       ->addDecorator('HttpHeaders');
        
        return $this;
    }
    
}