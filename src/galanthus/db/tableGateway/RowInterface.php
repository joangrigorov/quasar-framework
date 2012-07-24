<?php

namespace galanthus\db\tableGateway;

use Doctrine\DBAL\Driver\Connection;

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
     * Set row data
     *
     * @return array
     */
    public function getData();
    
}