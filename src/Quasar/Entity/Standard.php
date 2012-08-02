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

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Entity
 * @copyright  Copyright (c) 2012 Sasquatch
 */
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
    
    /**
     * Overriding: allow property access through getter method
     * 
     * @param string $name
     * @throws NoSuchFieldException
     * @return mixed
     */
    public function __get($name)
    {
        $getter = 'get' . ucfirst($name);
        
        if (!method_exists($this, $getter)) {
            throw new NoSuchFieldException("Specified field '$name' is not in the row");
        }
        
        return $this->$getter();
    }
    
    /**
     * Overriding: allow property access through setter method
     * 
     * @param string $name
     * @param mixed $value
     * @throws NoSuchFieldException
     */
    public function __set($name, $value)
    {
        $setter = 'set' . ucfirst($name);
        
        if (!method_exists($this, $setter)) {
            throw new NoSuchFieldException("Specified field '$name' is not in the row");
        }
        
        $this->$setter($value);
    }
    
}