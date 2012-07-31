<?php

namespace galanthus\db\tableGateway;

use galanthus\db\TableGatewayInterface,
    galanthus\db\tableGateway\RowsetException,
    \SeekableIterator,
    \Countable,
    \ArrayAccess;

class Rowset implements RowsetInterface, SeekableIterator, Countable, ArrayAccess
{
    
    /**
     * Rowset data
     * 
     * @var array
     */
    protected $data;
    
    /**
     * Row Data Gateways
     * 
     * @var array
     */
    protected $rows = array();
    
    /**
     * Prototype object used for row data gateways
     * 
     * Other rows clone from this one
     * 
     * @var RowInterface
     */
    protected $rowObjectPrototype;
    
    /**
     * Table Data Gateway that this rowset belongs to
     * 
     * @var TableGatewayInterface
     */
    protected $tableGateway;
    
    /**
     * Current position
     * 
     * @var integer
     */
    protected $pointer = 0;
    
    /**
     * Rows count
     * 
     * @var integer
     */
    protected $count;
    
    /**
     * Is rowset initiliazed? (is the data array set)
     * 
     * @var boolean
     */
    protected $isInitialized = false;
    
    /**
     * Contructor
     * 
     * Sets dependencies
     * 
     * @param array $data Rows data
     * @param TableGatewayInterface $tableGateway
     * @param RowInterface $rowObjectPrototype Row Data Gateway prototype object
     */
    public function __construct(array $data, TableGatewayInterface $tableGateway = null, RowInterface $rowObjectPrototype = null)
    {
        if (!empty($data)) {
            $this->init($data);
        }
        $this->rowObjectPrototype = (null === $rowObjectPrototype) ? new Row : $rowObjectPrototype;
        if (null !== $tableGateway) {
            $this->rowObjectPrototype->setTableGateway($tableGateway);
        }
    }
    
    /**
     * Initialize rowset data
     * 
     * @param array $data
     * @return Rowset
     */
    public function init(array $data)
    {
        if ($this->isInitialized) {
            return $this;
        }
        
        $this->isInitialized = true;
        $this->data = $data;
        $this->count = count($data);
        return $this;
    }
    
    /**
     * Set the row data gateway object prototype
     * 
     * Other row objects will be cloned from this one
     * 
     * @param RowInterface $rowObjectPrototype
     * @return Rowset
     */
    public function setRowObjectPrototype(RowInterface $rowObjectPrototype)
    {
        $this->rowObjectPrototype = $rowObjectPrototype;
        return $this;
    }
    
    /**
     * Get row data gateway object prototype
     * 
     * Other row objects will be cloned from this one
     * 
     * @return RowInterface
     */
    public function getRowObjectPrototype()
    {
        return $this->rowObjectPrototype;
    }
    
    /**
     * Set table gateway that this rowset belongs to
     * 
     * @param TableGatewayInterface $gateway
     * @return Rowset
     * @todo Update children rows
     */
    public function setTableGateway(TableGatewayInterface $gateway)
    {
        $this->tableGateway = $gateway;
        return $this;
    }
    
    /**
     * Required by Iterator interface
     *
     * @return Rowset Fluent interface
     */
    public function rewind()
    {
        $this->pointer = 0;
        return $this;
    }
    
    /**
     * Required by Iterator interface
     * 
     * @todo Return Row object
     * @return RowInterface current element from the collection
     */
    public function current()
    {
        
        if ($this->valid() === false) {
            return null;
        }
    
        // return the row object
        return $this->getRowInstance($this->pointer);
    }
    
    /**
     * Required by Iterator interface
     *
     * @return integer
     */
    public function key()
    {
        return $this->pointer;
    }
    
    /**
     * Required by Iterator interface
     *
     * @return void
     */
    public function next()
    {
        ++$this->pointer;
    }
    
    /**
     * Required by Iterator interface
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->pointer >= 0 && $this->pointer < $this->count;
    }
    
    /**
     * Required by Countable interface
     *
     * @return integer
     */
    public function count()
    {
        return $this->count;
    }
    
    /**
     * Required by SeekableIterator interface
     *
     * @param int $position the position to seek to
     * @return Rowset
     * @throws RowsetException
     */
    public function seek($position)
    {
        $position = (int) $position;
        if ($position < 0 || $position >= $this->count) {
            throw new RowsetException("Illegal index $position");
        }
        $this->pointer = $position;
        return $this;
    }
    
    /**
     * Required by ArrayAccess interface
     *
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->data[(int) $offset]);
    }
    
    /**
     * Required by ArrayAccess interface
     *
     * @param string $offset
     * @return Rowset
     * @throws RowsetException
     */
    public function offsetGet($offset)
    {
        $offset = (int) $offset;
        if ($offset < 0 || $offset >= $this->count) {
            throw new RowsetException("Illegal index $offset");
        }
        $this->pointer = $offset;
    
        return $this->current();
    }
    
    /**
     * Required by ArrayAccess interface
     *
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
    }
    
    /**
     * Required by ArrayAccess interface
     *
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
    }
    
    /**
     * Get (or create) row data gateway instance by given offset
     * 
     * @param integer $offset
     * @throws RowsetException When wrong offset is given
     * @return RowInterface
     */
    protected function getRowInstance($offset)
    {
        if (!array_key_exists($offset, $this->data)) {
            throw new RowsetException("Illigal index $offset");
        }
        
        if (array_key_exists($offset, $this->rows)) {
            return $this->rows[$offset];
        }
        
        $row = clone $this->rowObjectPrototype;
        $row->setData($this->data[$offset]);
                
        $this->rows[$offset] = $row;
        return $row;
    }
    
    /**
     * Get rowset as array of arrays
     * 
     * @return array
     */
    public function toArray()
    {
        $result = array();
        foreach ($this as $row) {
            $result[] = $row->toArray();
        }
        return $result;
    }
}