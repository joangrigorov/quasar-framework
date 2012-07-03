<?php
return array(
    'galanthus\dispatcher\Dispatcher' => array(
        'alias' => 'dispatcher'
    ),
    
    'galanthus\dispatcher\Response' => array(
        'call' => array('setInjector'),
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
    
    'galanthus\view\Renderer' => array(
        'params' => array(
            'paths' => array(
                ROOT_PATH . '/src/app/views/templates/'
            )
        )
    )
);