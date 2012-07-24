<?php
return array(
    'galanthus\env\config\IncludePath' => array(
        'params' => array(
            'paths' => array(
                ROOT_PATH . '/vendor/'
            )
        )
    ),
    
    'db-driver' => array(
        'params' => array(
            'params' => array(
                'dbname' => 'databg_cloud_service',
                'user' => 'root',
                'password' => '',
                'host' => 'localhost',
                'charset' => 'utf8'
            )
        )
    ),
        
    'galanthus\db\TableGateway' => array(
        'params' => array(
            'table' => 'files'
        )
    )
);