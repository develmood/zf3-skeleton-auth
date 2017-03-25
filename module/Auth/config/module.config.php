<?php
namespace Auth;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'auth' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/auth[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\AuthenticationController::class,
                        'action'     => 'index',
                    ]
                ]
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthenticationController::class => Controller\AuthenticationControllerFactory::class
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Zend\Session\Service\SessionManager::class => \Zend\Session\Service\SessionManagerFactory::class,
            Service\AuthenticationService::class => Service\AuthenticationServiceFactory::class,
            Service\AuthenticationAdapter::class => Service\AuthenticationAdapterFactory::class,
            // Service\MailService::class => Service\MailServiceFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'template_map' => [
            'layout/auth' => __DIR__ . '/../view/layout/auth.phtml',
        ]
    ],
    // 'recovery' => [
    //     'subject' => 'Password Recovery',
    //     'message' => 'Click the following link to create a new Password:'
    // ],
    // 'registration' => [
    //     'subject' => 'Registration',
    //     'message' => 'Click the following link to complete your registration:'
    // ]
];