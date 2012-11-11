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

use Quasar\Db\TableGateway\TableGatewayInterface,
    \ArrayAccess,
    \Countable;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Database
 * @subpackage Table Data Gateway
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Row implements RowInterface, ArrayAccess, Countable
{
    
    /**
     * Original data
     * 
     * @var array
     */
    protected $originalData;
    
    /**
     * Row data
     * 
     * @var array
     */
    protected $data;
    
    /**
     * Table Data Gateway
     * 
     * @var TableGatewayInterface
     */
    protected $gateway;

    /**
     * True if row exists in the database table
     * 
     * @var boolean
     */
    protected $existsInDatabase = false;
    
    /**
     * Consutrctor
     * 
     * @param boolean $existsInDatabase
     */
    public function __construct($existsInDatabase = true)
    {
        $this->existsInDatabase = $existsInDatabase;
    }
    
    /**
     * Sets row existance in database
     * 
     * @param boolean $existsInDatabase
     * @return Row
     */
    public function setExistsInDatabase($existsInDatabase = true)
    {
        $this->existsInDatabase = (boolean) $existsInDatabase;
        return $this;
    }
    
    /**
     * Set the Table Data Gateway instance
     *  
     * @param TableGatewayInterface $gateway
     * @return Row
     */
    public function setTableGateway(TableGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
        return $this;
    }
    
    /**
     * Get the Table Data Gateway instance
     * 
     * @return TableGatewayInterface
     */
    public function getTableGateway()
    {
        return $this->gateway;
    }
    
    /**
     * Set row data
     * 
     * @param array $data
     * @return Row
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }
    
    /**
     * Populate with new data
     * 
     * @param array $data
     * @return Row
     */
    public function populate(array $data)
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->data)) {
                $this->data[$key] = $value;
            }
        }
        
        return $this;
    }
    
    /**
     * Get row data as array
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Offset Exists
     *
     * @param  string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * Offset get
     *
     * @param  string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * Offset set
     *
     * @param  string $offset
     * @param  mixed $value
     * @return Row
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
        return $this;
    }

    /**
     * Offset unset
     *
     * @param  string $offset
     * @return Row
     */
    public function offsetUnset($offset)
    {
        $this->data[$offset] = null;
        return $this;
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Overriding: allowing row data access (reading)
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            throw new RowException("'$name' is not a valid column name");
        }
    }
    
    /**
     * Overriding: allowing row data acces (writing)
     * 
     * @param string $name
     * @param mixed $value
     * @throws RowException
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->data)) {
            $this->offsetSet($name, $value);
        } else {
            throw new RowException("'$name' is not a valid column name");
        }
    }
    
    /**
     * Save data to the database table
     *
     * If row doesn't exist - creates it
     *
     * @return integer
     */
    public function save()
    {
        $this->originalData = $this->data;
        
        if (!$this->existsInDatabase) {
            return $this->gateway->insert($this->data);
        }
        
        $primaryKeys = (array) $this->gateway->getPrimaryKey();
        
        $where = array();
        
        foreach ($primaryKeys as $key) {
            $where[$key] = $this->data[$key];
        }
        
        return $this->gateway->update($this->data, $where);
    }
    
}