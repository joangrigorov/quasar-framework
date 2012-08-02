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

use Quasar\View\Helper\HelperAbstract;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar View
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class BaseUrl extends HelperAbstract
{
    
    /**
     * Cache variable for the base url
     * 
     * @var string
     */
    protected static $baseUrl;
    
    /**
     * 
     * @param string $path
     * @return string
     */
    public function direct()
    {
        $path = func_get_arg(0);
        
        if (!is_string($path)) {
            throw new InvalidArgumentException('Path must be string');
        }
        
        $baseUrl = empty(self::$baseUrl) ? dirname($_SERVER['SCRIPT_NAME']) : self::$baseUrl;
        
        $path = empty($path) ? '' : $path;
        
        $firstChar = substr($path, 0, 1);
        
        if ('/' != $firstChar) {
            $path = '/' . $path;
        }
        
        return $baseUrl . $path;
    }
}