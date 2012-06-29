<?php

namespace galanthus\dispatcher;

use galanthus\dispatcher\request\Query;

/**
 * @todo Parses the requested url and finds the requested controller and etc.
 */
class Request implements RequestInterface
{
    
    /**
     * Query stack
     * 
     * @var Query
     */
    protected $_query;
    
    protected function _resolveUri()
    {
        $requestQuery = parse_url(
            str_replace(dirname($_SERVER['SCRIPT_NAME']), '', 
                    str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI'])
            )
        );
        
        $path = explode('/', $requestQuery['path']);
        
        if (!empty($path)) {
            foreach ($path as $entity) {
                if (empty($entity)) {
                    continue;
                }
                $this->_query->push($entity);
            }
        }        
    }
    
    /**
     * Sets the request query stack object
     * 
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->_query = $query;
        $this->_resolveUri();
    }
    
    /**
     * Get the query stack
     * 
     * @return Query
     */
    public function getQuery()
    {
        return $this->_query;
    }
    
}