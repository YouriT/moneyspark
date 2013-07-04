<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Api;
return array(
    'router' => array(
        'routes' => array(
            'api' => array(
                'type' => 'hostname',
                'options' => array(
                    'route'    => 'api.moneyspark',
                    'defaults' => array(
                    	'__NAMESPACE__' => 'api_',
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
            	'may_terminate' => true,
            	'child_routes' => array(
            		'default' => array(
            			'type' => 'Segment',
            			'options' => array(
            				'route' => '[/:controller[/:id]]',
            				'constraints' => array(
            					'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
            					'id' => '[a-zA-Z0-9_-]*',
            				)
            			)
            		),
				),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'api_index' => 'Api\Controller\IndexController'
        ),
    ),
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
	'view_manager' => array(
		'strategies' => array(
				'ViewJsonStrategy',
		),
	),
);
