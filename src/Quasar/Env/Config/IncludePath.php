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
 * @package    Quasar Environment
 * @subpackage Configuration
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Env\Config;

/**
 * Class for registering include paths
 * 
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Environment
 * @subpackage Configuration
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class IncludePath
{
    
    /**
     * Constructor
     * 
     * Set multiple paths in the include path
     * 
     * @param array $paths
     */
    public function __construct(array $paths = null)
    {
        if (null !== $paths) {
            foreach ($paths as $path) {
                $this->register($path);
            }
        }
    }
    
    /**
     * Register include path
     * 
     * The include path must valid
     * 
     * @param string $path
     * @throws ConfigException
     */
    protected function register($path)
    {
        if (null === $path) {
            return;
        }
        
        if (!file_exists($path)) {
            throw new ConfigException("'" . htmlspecialchars($path) . "' is not a valid path");
        }
        
        set_include_path(implode(PATH_SEPARATOR, array(
            realpath($path),
            get_include_path(),
        )));
    }
}