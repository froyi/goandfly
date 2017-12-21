<?php
return [
    'project' => [
        'name' => 'Go and Fly',
        'namespace' => 'Project'
    ],
    'template' => [
        'name' => 'goandfly',
        'dir' =>  '/goandfly',
    ],
    'database' => [
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'fly'
    ],
    'controller' => [
        'namespace' => 'Controller'
    ],
    'route' => [
        'index' => [
            'controller' => 'IndexController',
            'action' => 'indexAction'
        ],
        'migrate' => [
            'controller' => 'BackendController',
            'action' => 'migrateAction'
        ]
    ]
];