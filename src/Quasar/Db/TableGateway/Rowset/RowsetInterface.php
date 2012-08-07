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
 * @package    Quasar Database
 * @subpackage Table Data Gateway
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Db\TableGateway\Rowset;

use Quasar\Db\TableGateway\TableGatewayInterface;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Database
 * @subpackage Table Data Gateway
 * @copyright  Copyright (c) 2012 Sasquatch
 */
interface RowsetInterface
{
    
    /**
     * Set table data gateway instance
     * 
     * @param TableGatewayInterface $gateway
     * @return RowsetInterface
     */
    public function setTableGateway(TableGatewayInterface $gateway);
    
    /**
     * Initialize rowset data
     * 
     * @param array $data
     * @return RowsetInterface
     */
    public function init(array $data);
    
    /**
     * Get rowset as array of arrays
     * 
     * @return array
     */
    public function toArray();
    
}