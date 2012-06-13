<?php

namespace galanthus\dispatcher;

use galanthus\dispatcher\UrlResolverInterface;

interface DispatcherInterface
{
    public function setUrlResolver(UrlResolverInterface $urlResolver);
    
    public function getUrlResolver();
    
    public function dispatch();
}