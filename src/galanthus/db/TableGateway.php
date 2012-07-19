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

use Doctrine\DBAL\Query\QueryBuilder,
    Doctrine\DBAL\Connection,
    Doctrine\DBAL\Driver\Connection as DriverConnection;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Database
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class TableGateway implements TableGatewayInterface
{
    
    /**
     * Database connection
     * 
     * @var Connection
     */
    protected $connection;
    
    /**
     * Table name
     * 
     * @var string
     */
    protected $table;
    
    /**
     * Constructor. Sets dependencies.
     * 
     * Sets database connection
     * 
     * @param Connection $connection Doctrine DBAL connection driver
     * @param string $table DB Table name
     */
    public function __construct(Connection $connection, $table = null)
    {
        $this->connection = $connection;
        
        if (null !== $table) {
            $this->table = $table;
        }
    }
    
    /**
     * Set the database connection
     * 
     * @param DriverConnection $connection
     * @return TableGateway
     */
    public function setConnection(DriverConnection $connection)
    {
        $this->connection = $connection;
        return $this;
    }
    
    /**
     * Get the database connection
     * 
     * @return DriverConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }
    
    /**
     * Delete from the table
     * 
     * @param array $identifier
     * @return integer Number of affected rows
     */
    public function delete(array $identifier)
    {
        return $this->connection->delete($this->table, $identifier);
    }
    
    /**
     * Update table data
     * 
     * @param array $data
     * @param array $identifier
     * @param array $types
     * @return integer Number of affected rows
     */
    public function update(array $data, array $identifier, array $types = array())
    {
        return $this->connection->update($this->table, $data, $identifier, $types);
    }

    /**
     * Inserts a table row with specified data.
     *
     * @param array $data An associative array containing column-value pairs.
     * @param array $types Types of the inserted data.
     * @return integer The number of affected rows.
     */
    public function insert(array $data, array $types = array())
    {
        return $this->connection->insert($this->table, $data, $types);
    }
    
    /**
     * Prepares and executes an SQL query and returns the result as rowset of row data gateways.
     * 
     * @param QueryBuilder $query
     * @return array
     * @todo Return rowset of row data gateways
     */
    public function fetchAll(QueryBuilder $query = null)
    {
        if (null === $query) {
            $query = $this->select();
        }
        
        return $this->connection->fetchAll($query->getSQL());
    }
    
    /**
     * Prepares and executes an SQL query and returns the result as row data gateway.
     * 
     * @param QueryBuilder $query
     * @return array
     * @todo Return row data gateway
     */
    public function fetchRow(QueryBuilder $query = null)
    {
        if (null === $query) {
            $query = $this->select();
        }
        
        return $this->connection->fetchArray($query->getSQL());
    }
    
    /**
     * Construct select query
     * 
     * @param mixed $select The selection expressions.
     * @return QueryBuilder
     */
    public function select($select = '*')
    {
        return $this->connection
                    ->createQueryBuilder()
                    ->select('*')
                    ->from($this->table, null);
    }
    
}