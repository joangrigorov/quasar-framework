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
 * @package    Quasar Entity
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Entity;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Entity
 * @copyright  Copyright (c) 2012 Sasquatch
 */
interface Arrayable
{
    
    /**
     * Get entity's data
     *
     * @return array
     */
    public function toArray();
    
}