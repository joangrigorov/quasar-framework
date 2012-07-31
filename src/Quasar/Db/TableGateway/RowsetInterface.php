<?php

namespace Quasar\Db\TableGateway;

use Quasar\Db\TableGatewayInterface;

interface RowsetInterface
{
    
    public function setTableGateway(TableGatewayInterface $gateway);
    
    /**
     * Initialize rowset data
     * 
     * @param array $data
     * @return RowsetInterface
     */
    public function init(array $data);
    
    /**
     * Get rowset as array of arrays
     * 
     * @return array
     */
    public function toArray();
    
}