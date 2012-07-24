<?php

namespace galanthus\db\tableGateway;

use galanthus\db\TableGatewayInterface;

interface RowsetInterface extends \SeekableIterator, \Countable, \ArrayAccess
{
    
    public function setTableGateway(TableGatewayInterface $gateway);
    
}