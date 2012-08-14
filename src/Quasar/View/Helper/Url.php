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

use Quasar\View\Helper\AbstractHelper;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar View
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Url extends AbstractHelper
{
    
    /**
     * Cache variable for the base url
     * 
     * @var string
     */
    protected static $baseUrl;    
    
    /**
     * Convert camel cased string to dased case
     * 
     * @param string $controller
     * @return string
     */
    protected function camelToDashed($controller) 
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $controller));
    }
    
    /**
     * Url helper
     * 
     * Constructs URI addresses
     * 
     * @param array $controllers List of controllers to map
     * @param array $params List parameters to map
     * @return string
     */
    public function direct()
    {
        $controllers = func_get_arg(0);
        $params = func_get_arg(1);

        if (empty(self::$baseUrl)) {
            self::$baseUrl = dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : dirname($_SERVER['SCRIPT_NAME']);
        }
        
        $url = self::$baseUrl;
        
        if (!is_null($controllers) && !is_array($controllers)) {
            throw new InvalidArgumentException('Ivalid argument provided for controllers list');
        }
        
        if (!is_null($params) && !is_array($params)) {
            throw new InvalidArgumentException('Ivalid argument provided for parameters list');
        }
        
        if (!is_null($controllers)) {
            foreach ($controllers as $controller) {
                $url .= '/' . $this->camelToDashed($controller);
            }
        }
        
        if (!is_null($params)) {
            foreach ($params as $param => $value) {
                $value = strstr($value, '/') === false ? $value : urlencode($value);
                $url .= '/' . $this->camelToDashed($param) . '/' . urlencode($value);
            }
        }
        
        return $url;
    }
}