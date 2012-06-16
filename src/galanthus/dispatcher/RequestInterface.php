<?php
namespace galanthus\dispatcher;

/**
 * @todo Parses the requested url and finds the requested controller and etc.
 */
interface RequestInterface
{
    
    public function getQuery();
    
}