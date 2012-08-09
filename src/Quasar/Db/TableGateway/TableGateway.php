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

namespace Quasar\Db\TableGateway;

use Quasar\Db\TableGateway\Row\Row;

use Quasar\Db\TableGateway\Row\RowInterface;

use Quasar\Db\TableGateway\Rowset\Rowset,
    Quasar\Db\TableGateway\Rowset\RowsetInterface,
    Doctrine\DBAL\Query\QueryBuilder,
    Doctrine\DBAL\Connection,
    Doctrine\DBAL\Driver\Connection as DriverConnection;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Database
 * @subpackage Table Data Gateway
 * @copyright  Copyright (c) 2012 Sasquatch
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
     * Row data gateway prototype object
     * 
     * @var RowInterface
     */
    protected $rowObjectPrototype;
    
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
    public function __construct(Connection $connection, RowsetInterface $rowsetObjectPrototype = null, RowInterface $rowObjectPrototype = null, $table = null)
    {
        $this->connection = $connection;
        
        if (null !== $table) {
            $this->table = $table;
        }
        
        $this->rowsetObjectPrototype = (null === $rowsetObjectPrototype)
                                        ? new Rowset(array(), $this)
                                        : $rowsetObjectPrototype;
        
        $this->rowObjectPrototype = (null === $rowObjectPrototype)
                                     ? new Row
                                     : $rowObjectPrototype;
        
        $this->rowObjectPrototype->setTableGateway($this);
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
     * Set the row data gateway prototype object
     * 
     * @param RowInterface $prototype
     * @return TableGateway
     */
    public function setRowObjectPrototype(RowInterface $prototype)
    {
        $this->rowObjectPrototype = $prototype;
        return $this;
    }
    
    /**
     * Get the row data gateway prototype object
     * 
     * @return RowInterface
     */
    public function getRowObjectPrototype()
    {
        return $this->rowObjectPrototype;
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
     * @param array $params Parameters to bind
     * @param string $fetchStyle Fetching style to use
     * @return array|Rowset
     */
    public function fetchAll(QueryBuilder $query = null, array $params = array(), $fetchStyle = null)
    {
        if (null === $query) {
            $query = $this->select();
        }
                
        $resultRows = $this->connection->fetchAll($query->getSQL(), $params);
        
        $fetchStyle = (null === $fetchStyle) ? $this->defaultFetchStyle : $fetchStyle;
        
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
     * @param array $params Parameters to bind
     * @return array|Row|StdClass
     */
    public function fetchRow(QueryBuilder $query = null, array $params = array(), $fetchStyle = null)
    {
        if (null === $query) {
            $query = $this->select();
        }
        
        $resultRow = $this->connection->fetchAssoc($query->getSQL(), $params);
        
        $fetchStyle = (null === $fetchStyle) ? $this->defaultFetchStyle : $fetchStyle;
        
        switch ($fetchStyle) {
            case self::FETCH_ASSOC:
                return $resultRow;
                break;
            case self::FETCH_STD_OBJECT:
                return $this->arrayToStdClassObject($resultRow);
                break;
            default:
                $row = clone $this->rowObjectPrototype;
                $row->setData($resultRow);
                return $row;
                break;
        }
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