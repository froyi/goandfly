<?php
return [
    'project' => [
        'name' => 'Go and Fly',
        'namespace' => 'Project'
    ],
    'template' => [
        'name' => 'goandfly',
        'dir' => '/goandfly',
    ],
    /*'database' => [
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'root',
        'database' => 'goandfly'
    ],*/
    // _live_test
    'database' => [
        'host' => 'localhost',
        'user' => 'd002e083',
        'password' => '2006gofly0523',
        'database' => 'd002e083'
    ],
    /*'database' => [
        'host' => 'localhost',
        'user' => 'd017956f',
        'password' => 'veQfmf882Z3FCGpE',
        'database' => 'd017956f'
    ],*/
    'controller' => [
        'namespace' => 'Controller'
    ],
    'route' => [
        'index' => [
            'controller' => 'IndexController',
            'action' => 'indexAction',
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
            'action' => 'reiseAction',
            'js-packages' => [
                'fancybox' => true,
            ],
        ],
        'migrate' => [
            'controller' => 'BackendController',
            'action' => 'migrateAction',
            'js-packages' => [
                'ckeditor' => true,
            ],
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
            'action' => 'loggedInAction',
            'js-packages' => [
                'ckeditor' => true,
            ],
        ],
        'erstelle-reise' => [
            'controller' => 'BackendController',
            'action' => 'erstelleReiseAction',
            'js-packages' => [
                'ckeditor' => true,
            ],
        ],
        'erstelle-neuigkeiten' => [
            'controller' => 'BackendController',
            'action' => 'erstelleNeuigkeitenAction',
            'js-packages' => [
                'ckeditor' => true,
            ],
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
            'action' => 'bearbeiteNeuigkeitenAction',
            'js-packages' => [
                'ckeditor' => true,
            ],
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
            'action' => 'bearbeiteFrageFormAction',
            'js-packages' => [
                'ckeditor' => true,
            ],
        ],
        'bearbeite-termin-form' => [
            'controller' => 'BackendController',
            'action' => 'bearbeiteTerminFormAction',
            'js-packages' => [
                'ckeditor' => true,
            ],
        ],
        'bearbeite-reiseverlauf-form' => [
            'controller' => 'BackendController',
            'action' => 'bearbeiteReiseverlaufFormAction',
            'js-packages' => [
                'ckeditor' => true,
            ],
        ],
        'bearbeite-reise-form' => [
            'controller' => 'BackendController',
            'action' => 'bearbeiteReiseFormAction',
            'js-packages' => [
                'ckeditor' => true,
            ],
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
        'reisevorschauInsertSuccess' => 'Die Reise wurde erfolgreich angelegt. Jedoch nur als Vorlage. Es fehlen einige Daten.',
        'reisevorschauInsertError' => 'Die Reisevorlage konnte nicht erstellt werden.',
        'reiseInsertError' => 'Bei der Erstellung der Reise gab es einen Fehler.',
        'newsInsertSuccess' => 'Die Neuigkeit wurde erfolgreich angelegt.',
        'newsInsertError' => 'Bei der Erstellung der Neuigkeit gab es einen Fehler.',
        'newsDeleteSuccess' => 'Die Neuigkeit wurde erfolgreich gelöscht.',
        'reiseEditSuccess' => 'Die Reise wurde erfolgreich bearbeitet.',
        'reiseEditError' => 'Die Reise konnte nicht bearbeitet werden.',
    ],
    'tinypng-api-key' => 'oCp8yUGdePuUObLKVmhAHeB4V3zLbDZD',
    'js-packages' => [
        'fancybox' => '/js/fancybox.min.js',
        'ckeditor' => '/ckeditor/ckeditor.js',
        'responsive-slides' => '/js/responsiveSlides.min.js',
        'jquery' => '/js/jquery-3.2.1.min.js',
        'pageslide' => '/js/jquery.pageslide.min.js',
        'main' => '/js/main.min.js',
    ],
    'js-boxes' => [
        'main' => [
            'jquery' => true,
            'responsive-slides' => true,
            'pageslide' => true,
            'main' => true,
        ]
    ],
    'captcha-public-key' => '6LdaDUEdAAAAABa5FQrlHxG61WISbjVCA9OCyPJt',
    'captcha-private-key' => '6LdaDUEdAAAAAM1Y_8SFq-blyUjHDli4vmEdg9oW',
    'captcha-score' => 1,
];