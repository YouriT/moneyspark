<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Mobile;

return array(
    'router' => array(
        'routes' => array(
            'mobile' => array(
                'type' => 'hostname',
                'options' => array(
                    'route'    => 'm.reonin.com',
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Mobile',
                        'controller' => 'Index',
                    	'action' => 'index'
                    ),
                ),
            	'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Mobile',
                                'controller' => 'Index',
                            )
                        )
                    ),
                    'main' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Mobile',
                                'controller' => 'Index',
                            )
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'Mobile/layout' => __DIR__ . '/../view/layout/layout.phtml',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Mobile\Index' => 'Mobile\Controller\IndexController'
        ),
    ),
    'module_layouts' => array(
        'Mobile' => 'Mobile/layout'
    )
);


