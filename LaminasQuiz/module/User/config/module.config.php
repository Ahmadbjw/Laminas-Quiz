<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace User;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'signup' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/signup',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'create',
                    ],
                ],
            ],
            'login' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

             'profile' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/profile[/:id[/:username]]',
                    'constraints' => [
                        'id' => '[0-9]+',
                        'username' =>   '[a-zA-z][a-zA-Z0-9_-]+', 
                    ],
                    'defaults' => [
                        'controller' => Controller\ProfileController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

             'logout' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => Controller\LogoutController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            'forgot' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/forgot',
                    'defaults' => [
                        'controller' => Controller\PasswordController::class,
                        'action'     => 'forgot',
                    ],
                ],
            ],

            'reset' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/reset[/:id[/:token]]',
                    'constraints' => [
                        'id' => '[0-9]+',
                        'username' =>   '[a-zA-z][a-zA-Z0-9_-]+', 
                    ],
                    'defaults' => [
                        'controller' => Controller\PasswordController::class,
                        'action'     => 'reset',
                    ],
                ],
            ],

             'bjs' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/bjs',
                    'defaults' => [
                        'controller' => Controller\BjsController::class,
                        'action'     => 'testing',
                    ],
                ],
            ],

            'viewpdf' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/viewpdf',
                    'defaults' => [
                        'controller' => Controller\BjsController::class,
                        'action'     => 'pdfshow',
                    ],
                ],
            ],




        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => Controller\Factory\AuthControllerFactory::class,
            Controller\LoginController::class => Controller\Factory\LoginControllerFactory::class,
            Controller\ProfileController::class => InvokableFactory::class,
            Controller\LogoutController::class => InvokableFactory::class,
            Controller\PasswordController::class => Controller\Factory\PasswordControllerFactory::class,
            Controller\BjsController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        // 'display_not_found_reason' => true,
        // 'display_exceptions'       => true,
        // 'doctype'                  => 'HTML5',
        // 'not_found_template'       => 'error/404',
        // 'exception_template'       => 'error/index',
        'template_map' => [
            'auth/create'           => __DIR__ . '/../view/user/auth/create.phtml',
            'login/index'           => __DIR__ . '/../view/user/auth/login.phtml',  
            'profile/index'         => __DIR__ . '/../view/user/profile/index.phtml',  
            'Password/reset'         => __DIR__ . '/../view/user/profile/index.phtml',  
            'password/forget'       => __DIR__ . '/../view/user/auth/reset.phtml',  
            // 'bjs/testing'           => __DIR__ . '/../view/user/bjs/testing.phtml',  
            // 'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            // 'error/404'               => __DIR__ . '/../view/error/404.phtml',
            // 'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
