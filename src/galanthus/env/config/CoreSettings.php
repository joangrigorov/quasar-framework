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
 * @subpackage Configuration
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\env\config;

/**
 * PHP core settings
 * 
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Environment
 * @subpackage Configuration
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class CoreSettings
{
    
    /**
     * Sets PHP ini settings
     *
     * @param boolean $displayErrors Sets the display_errors ini flag
     * @param boolean $logErrors Shoul errors be logged in a file?
     * @param string|null $errorLog Error log file path
     * @param integer $errorReportingLevel Error reporting level
     */
    public function __construct($displayErrors = false, $logErrors = true,
            $errorLog = null, $errorReportingLevel = E_ALL)
    {
        ini_set('display_errors', (int) $displayErrors);
        ini_set('log_errors', (int) $logErrors);
        if (null !== $errorLog) {
            ini_set('error_log', $errorLog);
        }
        error_reporting($errorReportingLevel);
    }
}