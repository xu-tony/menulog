<?php
return array(
    'router' => array(
        'routes' => array(

            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'home' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller'    => 'Menulog\Controller\Index',
                        'action'        => 'index',
                    ),
                ),
            ),

            'restaurants' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/restaurants',
                    'defaults' => array(
                        'controller'    => 'Menulog\Controller\Restaurants',
                        'action'        => 'restaurants',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'details' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '[/:id]',
                            'constrains' => array(
                                'id' => '[0-9]\d*'
                            ),
                            'defaults' => array(
                                'action' => 'details',
                            ),
                        )
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'Menulog\Controller\Index' => 'Menulog\Controller\IndexController'
        ),
        'factories' => array(
            'Menulog\Controller\Restaurants' => 'Menulog\Factory\RestaurantsControllerFactory'
        )
    ),

    'service_manager' => array(
        'factories' => array(
            'Menulog\Service\RestaurantsServiceInterface' => 'Menulog\Factory\RestaurantsServiceFactory',
            'Menulog\Mapper\RestaurantsMapperInterface'   => 'Menulog\Factory\RestaurantsMapperFactory'
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),

    'translator' => array(
        'locale' => 'en_US',
    ),

    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'application' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),


);