<?php
    namespace Album;

    //The segment route allows us to specify placeholders in the URL pattern (route) 
    //that will be mapped to named parameters in the matched route. 
    //the route /album[/:action[/:id]] for example
    use Laminas\Router\Http\Segment;
    
    //use Laminas\ServiceManager\Factory\InvokableFactory;
    use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

    use Album\Model\AlbumTableFactory;

    return [
        'controllers' => [
            'factories' => [
                //Controller\AlbumController::class => InvokableFactory::class,
                Controller\AlbumController::class => ReflectionBasedAbstractFactory::class
            ],
        ],

        //rotas do blog [home, add, edit, delete]
        'router' => [
            'routes' => [
                'album' => [
                    'type' => Segment::class,
                    'options' => [
                        //the square brackets indicate that a segment is optional
                        'route' => '/album[/:action[/:id]]',
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[0-9]+',
                        ],
                        'defaults' => [
                            'controller' => Controller\AlbumController::class,
                            'action' => 'index',
                        ],
                    ],
                ],
            ],
        ],

        'view_manager' => [
            'template_path_stack' => [
                'album' => __DIR__ . '/../view',
            ],
        ],

        'service_manager' => [
            'factories' => [
                Model\AlbumTable::class => AlbumTableFactory::class,
            ],
        ]
    ];


/**
 * The config information is passed to the relevant components by the 
 * ServiceManager. We need two initial sections: controllers and view_manager. 
 * The controllers section provides a list of all the controllers provided by 
 * the module. We will need one controller, AlbumController; we'll reference 
 * it by its fully qualified class name, and use the laminas-servicemanager 
 * InvokableFactory to create instances of it.
**/