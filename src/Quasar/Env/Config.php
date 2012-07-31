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
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Env;

use Quasar\Env\Config\IncludePath,
    Quasar\Env\Config\CoreSettings;

/**
 * Environment configuration
 * 
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Environment
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Config
{
    
    /**
     * Using just for instantiating configuration classes
     * 
     * @param CoreSettings $coreSettings
     */
    public function __construct(CoreSettings $coreSettings)
    {
    }
    
}