<?php
namespace Application;

use Zend\Mvc\Router\Http\Literal;
use Zend\Mvc\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return array(
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'recipe' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/phones[/:id]',
                    'defaults' => array(
                        'controller' => Controller\Rest\PhoneController::class,
                    ),
                ),
            )
        ],
    ],
    'application' => array(
        'type'    => 'Literal',
        'options' => array(
            'route'    => '/application',
            'defaults' => array(
                '__NAMESPACE__' => 'Application\Controller',
                'controller'    => Controller\IndexController::class,
                'action'        => 'index',
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            Controller\IndexController::class => ServiceFactory\Controller\IndexControllerFactory::class,
            Controller\Rest\PhoneController::class => ServiceFactory\Controller\Rest\PhoneControllerFactory::class,
        ),
//        'invokables' => array(
//            Controller\IndexController::class => Controller\IndexController::class,
//            Controller\Rest\PhoneController::class => InvokableFactory::class,
//        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
            Model\PhoneTable::class => ServiceFactory\Model\PhoneTableFactory::class,
            Service\IndexService::class => ServiceFactory\Service\IndexServiceFactory::class,
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout'    => __DIR__ . '/../view/layout/layout.phtml',
            'base/index/index' => __DIR__ . '/../view/base/index/index.phtml',
            'error/404'        => __DIR__ . '/../view/error/404.phtml',
            'error/index'      => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        )
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(),
        ),
    ),
);
