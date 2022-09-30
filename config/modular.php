<?php


return [
    'path' => base_path()."/app/Modules",

    'groupWithoutPrefix' => 'Pub',
    'groupMidleware' => [
        'Admin' => [
            'web' => ['auth'],
            'api' => ['auth:api'],
        ]
    ],
    'modules' => [
        'Admin' => [
            'Analitics',
            'LeadComment',
            'Lead',
            'Sources',
            'Role',
            'Menu',
            'Dashboard',
            'User', 
        ],
        'Pub' => [
            'Auth',
        ],
    ],
];