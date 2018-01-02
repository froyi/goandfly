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
        'reise' => [
            'controller' => 'IndexController',
            'action' => 'reiseAction'
        ],
        'migrate' => [
            'controller' => 'BackendController',
            'action' => 'migrateAction'
        ],
        'filter-reisen' => [
            'controller' => 'JsonController',
            'action' => 'filterReisenAction'
        ],
        'navigation-regions' => [
            'controller' => 'JsonController',
            'action' => 'navigationRegionsAction'
        ],
        'login' => [
            'controller' => 'IndexController',
            'action' => 'loginAction'
        ],
        'login-redirect' => [
            'controller' => 'IndexController',
            'action' => 'loginRedirectAction'
        ],
        'loggedin' => [
            'controller' => 'BackendController',
            'action' => 'loggedInAction'
        ],
        'erstelle-reise' => [
            'controller' => 'BackendController',
            'action' => 'erstelleReiseAction'
        ],
        'erstelle-neuigkeiten' => [
            'controller' => 'BackendController',
            'action' => 'erstelleNeuigkeitenAction'
        ],
        'ajax-bearbeite-neuigkeiten' => [
            'controller' => 'JsonController',
            'action' => 'bearbeiteNeuigkeitenAction'
        ],
        'bearbeite-neuigkeiten' => [
            'controller' => 'BackendController',
            'action' => 'bearbeiteNeuigkeitenAction'
        ]
    ],
    'startpage-offer' => 20,
    'reise-recommender-offer' => 3,
    'notification' => [
        'reiseInsertSuccess' => 'Die Reise wurde erfolgreich angelegt.',
        'reiseInsertError' => 'Bei der Erstellung der Reise gab es einen Fehler.',
        'newsInsertSuccess' => 'Die Neuigkeit wurde erfolgreich angelegt.',
        'newsInsertError' => 'Bei der Erstellung der Neuigkeit gab es einen Fehler.',
        'newsDeleteSuccess' => 'Die Neuigkeit wurde erfolgreich gelöscht.',
    ],
];