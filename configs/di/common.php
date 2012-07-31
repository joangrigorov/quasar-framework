<?php
return array(
    'Quasar\Env\Config\IncludePath' => array(
        'params' => array(
            'paths' => array(
                ROOT_PATH . '/vendor/'
            )
        )
    ),
    
    'db-driver' => array(
        'params' => array(
            'params' => array(
                'dbname' => 'proventus',
                'user' => 'root',
                'password' => '',
                'host' => 'localhost',
                'charset' => 'utf8'
            )
        )
    ),
        
    'Quasar\Db\TableGateway\TableGateway' => array(
        'params' => array(
            'table' => 'cities'
        )
    )
);