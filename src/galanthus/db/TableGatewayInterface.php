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
 * @package    Galanthus Database
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\db;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Database
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

use Doctrine\DBAL\Query\QueryBuilder,
    Doctrine\DBAL\Connection,
    Doctrine\DBAL\Driver\Connection as DriverConnection;

interface TableGatewayInterface
{

   /**@#+
    * Fetch styles
    */
    const FETCH_ROW_OBJ = 'fetchRowObject';
    const FETCH_ASSOC = 'fetchAssoc';
    const FETCH_STD_OBJECT = 'fetchAssoc';
    /**@#-*/
    
    /**
     * Set the database connection
     * 
     * @param DriverConnection $driver
     * @return TableGatewayInterface
     */
    public function setConnection(DriverConnection $connection);
    
    /**
     * Get the database connection
     * 
     * @return DriverConnection
     */
    public function getConnection();
    
    /**
     * Set default fetch style
     * 
     * @param string $fetchStyle
     * @return TableGatewayInterface
     */
    public function setFetchStyle($fetchStyle);
    
    /**
     * Get default fetch style
     * 
     * @return string
     */
    public function getFetchStyle();
    
    /**
     * Delete from the table
     * 
     * @param array $identifier
     * @return integer Number of affected rows
     */
    public function delete(array $identifier);
    
    /**
     * Update table data
     * 
     * @param array $data
     * @param array $identifier
     * @param array $types
     * @return integer Number of affected rows
     */
    public function update(array $data, array $identifier, array $types = array());

    /**
     * Inserts a table row with specified data.
     *
     * @param array $data An associative array containing column-value pairs.
     * @param array $types Types of the inserted data.
     * @return integer The number of affected rows.
     */
    public function insert(array $data, array $types = array());
    
    /**
     * Prepares and executes an SQL query and returns the result as rowset of row data gateways.
     * 
     * @param QueryBuilder $query
     * @return array
     */
    public function fetchAll(QueryBuilder $query = null);
    
    /**
     * Prepares and executes an SQL query and returns the result as row data gateway.
     * 
     * @param QueryBuilder $query
     * @return array
     */
    public function fetchRow(QueryBuilder $query = null);
    
    /**
     * Construct select query
     * 
     * @param mixed $select The selection expressions.
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function select($select = '*');
    
}