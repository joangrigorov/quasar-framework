<?php
/*
 * This is not supposed to be edited. Use common.php 
 * or enviornment specific configuration files.
 */
return array(
        
    // dispatcher configuration
    'galanthus\dispatcher\Dispatcher' => array(
        'alias' => 'dispatcher',
        'instances' => array(
            'galanthus\broker\HelperBroker' => array(
                'params' => array(
                    'namespaces' => array(
                        'galanthus\controller\helpers'
                    )
                )
            )
        )
    ),
    
    // response object configuration
    'galanthus\dispatcher\Response' => array(
        'params' => array(
            'decorators' => array(
                'httpHeaders' => array(
                    'headers' => array(
                        'Content-Type: text/html'
                    )
                ),
                'renderer', 
                'layout' => array(
                    'params' => array(
                        'title' => 'Galanthus Framework'
                    )
                )
            ),
            'params' => array('_layout' => 'layout')
        )
    ),
        
    // standart view renderer configuration
    'galanthus\view\Renderer' => array(
        'params' => array(
            'paths' => array(
                ROOT_PATH . '/src/app/views/templates/'
            )
        ),
        'instances' => array(
            'galanthus\broker\HelperBroker' => array(
                'params' => array(
                    'namespaces' => array(
                        'galanthus\view\helpers'
                    )
                )
            )
        )
    ),
        
);