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
        'ueber-uns' => [
            'controller' => 'IndexController',
            'action' => 'ueberUnsAction'
        ],
        'partner' => [
            'controller' => 'IndexController',
            'action' => 'partnerAction'
        ],
        'kontakt' => [
            'controller' => 'IndexController',
            'action' => 'kontaktAction'
        ],
        'impressum' => [
            'controller' => 'IndexController',
            'action' => 'impressumAction'
        ],
        'diamir' => [
            'controller' => 'IndexController',
            'action' => 'diamirAction'
        ],
        'migrate' => [
            'controller' => 'BackendController',
            'action' => 'migrateAction'
        ]
    ]
];