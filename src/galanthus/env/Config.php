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
 * @package    Galanthus Environment
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\env;

use galanthus\env\config\IncludePath,
    galanthus\env\config\CoreSettings;

/**
 * Environment configuration
 * 
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Environment
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Config
{
    
    /**
     * Using just for instantiating configuration classes
     * 
     * @param CoreSettings $coreSettings
     * @param IncludePath $autoload
     */
    public function __construct(CoreSettings $coreSettings, 
                                IncludePath $autoload)
    {
    }
    
}