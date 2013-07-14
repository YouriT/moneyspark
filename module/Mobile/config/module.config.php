<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Mobile;

if(!preg_match("#moneyspark#", $_SERVER["HTTP_HOST"]))
	$r = "m.reonin.com";
else
	$r = "m.moneyspark";

return array(
    'router' => array(
        'routes' => array(
            'mobile' => array(
                'type' => 'hostname',
                'options' => array(
                    'route'    => $r,
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Mobile',
                        'controller' => 'Index',
                    	'action' => 'index'
                    ),
                ),
            	'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'mobile_index' => 'Mobile\Controller\IndexController'
        ),
    )
);


