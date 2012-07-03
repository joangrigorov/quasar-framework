<?php
return array(
        
    // dispatcher configuration
    'galanthus\dispatcher\Dispatcher' => array(
        'alias' => 'dispatcher'
    ),
    
    // response object configuration
    'galanthus\dispatcher\Response' => array(
        'params' => array(
            'decorators' => array(
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
        )
    )
);