<?php
namespace galanthus\dispatcher;

/**
 * @todo Parses the requested url and finds the requested controller and etc.
 */
interface RequestInterface
{
    
    /**
     * Get the request query object
     * 
     * @return \galanthus\dispatcher\request\Query
     */
    public function getQuery();
    
}