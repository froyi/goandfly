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
    'database_local' => [
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'fly'
    ],
    // _live_test
    'database' => [
        'host' => 'localhost',
        'user' => 'd002e083',
        'password' => '2006gofly0523',
        'database' => 'd002e083'
    ],
//    'database_live' => [
//        'host' => 'localhost',
//        'user' => 'd017956f',
//        'password' => 'veQfmf882Z3FCGpE',
//        'database' => 'd017956f'
//    ],
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
        'ajax-bearbeite-reise' => [
            'controller' => 'JsonController',
            'action' => 'bearbeiteReiseAction'
        ],
        'bearbeite-neuigkeiten' => [
            'controller' => 'BackendController',
            'action' => 'bearbeiteNeuigkeitenAction'
        ],
        'ajax-erstelle-frage' => [
            'controller' => 'JsonController',
            'action' => 'erstelleFrageAction'
        ],
        'ajax-bearbeite-frage' => [
            'controller' => 'JsonController',
            'action' => 'bearbeiteFrageAction'
        ],
        'ajax-erstelle-leistungen' => [
            'controller' => 'JsonController',
            'action' => 'erstelleLeistungenAction'
        ],
        'ajax-erstelle-reiseverlauf' => [
            'controller' => 'JsonController',
            'action' => 'erstelleReiseverlaufAction'
        ],
        'ajax-erstelle-reisetermin' => [
            'controller' => 'JsonController',
            'action' => 'erstelleReiseterminAction'
        ],
        'ajax-bearbeite-reiseverlauf' => [
            'controller' => 'JsonController',
            'action' => 'bearbeiteReiseverlaufAction'
        ],
        'ajax-erstelle-tag' => [
            'controller' => 'JsonController',
            'action' => 'erstelleTagAction'
        ],
        'ajax-bearbeite-termin' => [
            'controller' => 'JsonController',
            'action' => 'bearbeiteTerminAction'
        ],
        'bearbeite-frage-form' => [
            'controller' => 'BackendController',
            'action' => 'bearbeiteFrageFormAction'
        ],
        'bearbeite-termin-form' => [
            'controller' => 'BackendController',
            'action' => 'bearbeiteTerminFormAction'
        ],
        'bearbeite-reiseverlauf-form' => [
            'controller' => 'BackendController',
            'action' => 'bearbeiteReiseverlaufFormAction'
        ],
        'bearbeite-reise-form' => [
            'controller' => 'BackendController',
            'action' => 'bearbeiteReiseFormAction'
        ],
        'kontakt-mailer' => [
            'controller' => 'MailerController',
            'action' => 'contactFormAction'
        ],
        'footer-contact' => [
            'controller' => 'MailerController',
            'action' => 'footerContactAction'
        ],
        'reise-contact' => [
            'controller' => 'MailerController',
            'action' => 'reiseContactAction'
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