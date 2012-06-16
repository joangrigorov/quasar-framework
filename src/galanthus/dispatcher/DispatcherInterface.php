<?php

namespace galanthus\dispatcher;

interface DispatcherInterface
{
        
    public function getRequest();
    
    public function dispatch();
    
    public function getResponse();
    
    public function output();
    
}