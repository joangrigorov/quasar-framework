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

use galanthus\db\tableGateway\Rowset;

use galanthus\db\tableGateway\RowsetInterface;

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
     * Default fetch style
     * 
     * @var string
     */
    protected $defaultFetchStyle = self::FETCH_ROW_OBJ;
    
    /**
     * Rowset prototype object
     * 
     * @var RowsetInterface
     */
    protected $rowsetObjectPrototype;
    
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
    public function __construct(Connection $connection, RowsetInterface $rowsetObjectPrototype = null, $table = null)
    {
        $this->connection = $connection;
        
        if (null !== $table) {
            $this->table = $table;
        }
        
        $this->rowsetObjectPrototype = (null === $rowsetObjectPrototype)
                                        ? new Rowset(array(), $this)
                                        : $rowsetObjectPrototype;
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
     * Set default fetch style
     * 
     * @param string $fetchStyle
     * @return TableGateway
     */
    public function setFetchStyle($fetchStyle)
    {
        $this->defaultFetchStyle = $fetchStyle;
        return $this;
    }
    
    /**
     * Get default fetch style
     * 
     * @return string
     */
    public function getFetchStyle()
    {
        return $this->defaultFetchStyle;
    }
    
    /**
     * Set the rowset prototype object
     * 
     * @param RowsetInterface $prototype
     * @return TableGateway
     */
    public function setRowsetObjectPrototype(RowsetInterface $prototype)
    {
        $this->rowsetObjectPrototype = $prototype;
        return $this;
    }
    
    /**
     * Get the rowset prototype object
     * 
     * @return RowsetInterface
     */
    public function getRowsetObjectPrototype()
    {
        return $this->rowsetObjectPrototype;
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
     * Convert array to stdClass object
     * 
     * @param array $array
     * @return StdClass
     */
    protected function arrayToStdClassObject($array) 
    {
		if (is_array($array)) {
			return (object) array_map(array($this, __METHOD__), $array);
		}
		else {
			return $array;
		}
	}
    
    /**
     * Prepares and executes an SQL query and returns the result as rowset of row data gateways.
     * 
     * @param QueryBuilder $query
     * @return array
     * @todo Return rowset of row data gateways
     */
    public function fetchAll(QueryBuilder $query = null, $fetchStyle = null)
    {
        if (null === $query) {
            $query = $this->select();
        }
        
        $fetchStyle = (null === $fetchStyle) ? $this->defaultFetchStyle : $fetchStyle;
        
        $resultRows = $this->connection->fetchAll($query->getSQL());
        
        switch ($fetchStyle) {
            case self::FETCH_ASSOC:
                return $resultRows;
            break;
            case self::FETCH_STD_OBJECT:
                foreach ($resultRows as &$row) {
                    $row = $this->arrayToStdClassObject($row);
                }
                return $resultRows;
            break;
            default:
                $rowset = clone $this->rowsetObjectPrototype;
                $rowset->init($resultRows);
                return $rowset;
            break;
        }
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