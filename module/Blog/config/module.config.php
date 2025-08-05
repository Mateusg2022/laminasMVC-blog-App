<?php

// In /module/Blog/config/module.config.php:
namespace Blog;

use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'aliases' => [
            // Model\PostRepositoryInterface::class => Model\PostRepository::class,
            Model\PostRepositoryInterface::class => Model\LaminasDbSqlRepository::class,
        ],
        'factories' => [
            Model\PostRepository::class => InvokableFactory::class,
            Model\LaminasDbSqlRepository::class => Factory\LaminasDbSqlRepositoryFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            //Controller\ListController::class => InvokableFactory::class,
            Controller\ListController::class => Factory\ListControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'blog' => [
                // Define a "literal" route type:
                'type' => Literal::class,
                'options' => [
                    'route' => '/blog',
                    'defaults' => [
                        'controller' => Controller\ListController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];