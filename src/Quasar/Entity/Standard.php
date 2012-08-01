<?php

namespace Quasar\Entity;

use \ArrayAccess,
    \IteratorAggregate,
    \ArrayIterator;

abstract class Standard implements Populatable, Arrayable
{
    
    /**
     * Populate entity's data
     * 
     * @param array $data
     * @return Standard
     */
    public function populate(array $data)
    {
        if (!is_null($data)) {
            foreach ($data as $name => $value) {
                $setter = 'set' . ucfirst($name);
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                }
            }
        }
        
        return $this;
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
}