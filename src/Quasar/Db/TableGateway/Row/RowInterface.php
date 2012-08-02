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

namespace Quasar\Db\TableGateway\Row;

use Quasar\Db\TableGateway\TableGatewayInterface;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Database
 * @subpackage Table Data Gateway
 * @copyright  Copyright (c) 2012 Sasquatch
 */
interface RowInterface
{

    /**
     * Set the Table Data Gateway instance
     *
     * @param TableGatewayInterface $gateway
     * @return RowInterface
     */
    public function setTableGateway(TableGatewayInterface $gateway);
    
    /**
     * Get the Table Data Gateway instance
     *
     * @return TableGatewayInterface
     */
    public function getTableGateway();
    
    /**
     * Set row data
     *
     * @param array $data
     * @return RowInterface
     */
    public function setData(array $data);
    
    /**
     * Get data as array
     * 
     * @return array
     */
    public function toArray();
    
    
//     public function save();
    
//     public function delete();
    
}