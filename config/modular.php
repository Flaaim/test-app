<?php


return [
    'path' => base_path()."/app/Modules",

    'groupWithoutPrefix' => 'Pub',
    
    'modules' => [
        'Admin' => [
            'User', 
        ],
        'Pub' => [
            'Dashboard',
            'Auth',
        ],
    ],
];