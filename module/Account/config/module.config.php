<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Account;
return array(
//     'router' => array(
//         'routes' => array(
//             'home' => array(
//                 'type' => 'Zend\Mvc\Router\Http\Literal',
//                 'options' => array(
//                     'route'    => '/',
//                     'defaults' => array(
//                         'controller' => 'Application\Controller\Index',
//                         'action'     => 'index',
//                     ),
//                 ),
//             ),
//             // The following is a route to simplify getting started creating
//             // new controllers and actions without needing to create a new
//             // module. Simply drop new controllers in, and you can access them
//             // using the path /application/:controller/:action
//             'application' => array(
//                 'type'    => 'Literal',
//                 'options' => array(
//                     'route'    => '/application',
//                     'defaults' => array(
//                         '__NAMESPACE__' => 'Application\Controller',
//                         'controller'    => 'Index',
//                         'action'        => 'index',
//                     ),
//                 ),
//                 'may_terminate' => true,
//                 'child_routes' => array(
//                     'default' => array(
//                         'type'    => 'Segment',
//                         'options' => array(
//                             'route'    => '/[:controller[/:action]]',
//                             'constraints' => array(
//                                 'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                 'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
//                             ),
//                             'defaults' => array(
//                             ),
//                         ),
//                     ),
//                 ),
//             ),
//         ),
//     ),
//     'controllers' => array(
//         'invokables' => array(
//             'account_index' => 'Account\Controller\IndexController'
//         ),
//     ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
);
