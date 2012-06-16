<?php
namespace galanthus\dispatcher;

/**
 * @todo Parses the requested url and finds the requested controller and etc.
 */
class Response implements ResponseInterface
{
    
    public function __construct()
    {
        ob_start();
    }

    public function output()
    {
        ob_end_flush();
    }
    
}