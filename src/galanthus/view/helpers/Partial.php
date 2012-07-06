<?php

namespace galanthus\view\helpers;

use galanthus\view\HelperException,
    galanthus\view\HelperAbstract;

class Partial extends HelperAbstract
{

    /**
     * Renderers view script
     * 
     * @param string $script
     * @param array $params
     * @return string
     * @throws HelperException When $script is not string
     */
    public function direct()
    {
        if (!func_num_args()) {
            return null;
        }
        
        $arguments = func_get_args();
                
        $renderer = clone $this->renderer;
        $renderer->clearParams();
        
        if (!is_string($arguments[0])) {
            throw new HelperException('View script path must be string');
        }
        
        if (isset($arguments[1]) && is_array($arguments[1])) {
            $renderer->setParams($arguments[1]);
        }
        
        return $renderer->render('test-partial.phtml');
    }
    
}