<?php

namespace galanthus\db\tableGateway;

use galanthus\db\TableGatewayInterface;

class Row implements RowInterface
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
     * Set row data
     * 
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

}