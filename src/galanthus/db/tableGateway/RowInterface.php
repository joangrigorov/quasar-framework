<?php

namespace galanthus\db\tableGateway;

use galanthus\db\TableGatewayInterface;

interface RowInterface
{

    /**
     * Set the Table Data Gateway instance
     *
     * @param TableGatewayInterface $gateway
     * @return RowInterface
     */
    public function setTableGateway(TableGatewayInterface $gateway);
    
    /**
     * Get the Table Data Gateway instance
     *
     * @return TableGatewayInterface
     */
    public function getTableGateway();
    
    /**
     * Set row data
     *
     * @param array $data
     * @return RowInterface
     */
    public function setData(array $data);
    
    /**
     * Get data as array
     * 
     * @return array
     */
    public function toArray();
    
    
//     public function save();
    
//     public function delete();
    
}