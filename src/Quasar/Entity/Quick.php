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

use \ArrayAccess,
    \IteratorAggregate,
    \ArrayIterator;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Entity
 * @copyright  Copyright (c) 2012 Sasquatch
 */
abstract class Quick implements Populatable, Arrayable, ArrayAccess, IteratorAggregate
{
    
    /**
     * Data fields
     *
     * @var array
     */
    protected $data = null;
    
    /**
     * Temporary copy of the original data values
     *
     * Needed for the {@see reset()} method
     *
     * @var array
     */
    protected $defaultValues = null;
    
    /**
     * Populate entity's data
     * 
     * @param array $data
     * @return Quick
     */
    public function populate(array $data)
    {
        if (!is_null($data)) {
            foreach ($data as $name => $value) {
                $this->{$name} = $value;
            }
        }
        
        return $this;
    }
    
    /**
     * Set entity's data
     *
     * @param array $data
     * @return Quick
     */
    public function setData(array $data)
    {
        $this->defaultValues = $data;
        $this->populate($data);
        return $this;
    }
    
    /**
     * Set entity's value
     *
     * @param string $name
     * @param mixed $value
     * @return Quick
     */
    public function set($name, $value)
    {
        $this->{$name} = $value;
        return $this;
    }
    
    /**
     * Get entity's value
     *
     * @param string $name
     * @return mixed $value
     */
    public function get($name)
    {
        return $this->{$name};
    }
    
    /**
     * Get entity's data
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
    
    /**
     * Set to null all the fields
     *
     * @return Quick
     */
    public function reset()
    {
        
        if (is_null($this->defaultValues)) {
            $classReflection = new \ReflectionClass($this);
            $defaultProperties = $classReflection->getDefaultProperties();
            if (isset($defaultProperties['data'])) {
                $this->defaultValues = $defaultProperties['data'];
            }
        }
        
        $this->data = $this->defaultValues;
        return $this;
    }
    
    /**
     * Set row field value
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->data)) {
            $this->data[$name] = $value;
        } else if (method_exists($this, 'set' . ucfirst($name))) {
            $setter = 'set' . ucfirst($name);
            $this->$setter($value);
        }
    }
    
    /**
     * Retrieve row field value
     *
     * @param  string $name The user-specified field name.
     * @return string       The corresponding field value.
     * @throws NoSuchFieldException if the specified field is not found in the $data array
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            throw new NoSuchFieldException("Specified field '$name' is not in the row");
        }
    }
    
    /**
     * Test existence of row field
     *
     * @param  string $name The field
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }
    
    /**
     * Unset row field value
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        if (isset($this->data[$name])) {
            $this->data[$name] = null;
        }
    }
    
    /**
     * Proxy to __isset
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }
    
    /**
     * Proxy to __get
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     * @return string
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }
    
    /**
     * Proxy to __set
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }
    
    /**
     * Proxy to __unset
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        return $this->__unset($offset);
    }
    
    /**
     * Required by the IteratorAggregate implementation.
     *
     * @see IteratorAggregate::getIterator()
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator((array) $this->data);
    }
}