<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
	'console' => array(
	    'router' => array(
	        'routes' => array(
	            'cli-create-appcache' => array(
	                'options' => array(
	                    'route'    => 'create appcache',
	                    'defaults' => array(
	                        'controller' => 'Cli\Create',
	                    	'action' => 'appcache'
	                    ),
	                ),
	            ),
        		'cli-empty-appcache' => array(
        				'options' => array(
        						'route'    => 'empty appcache',
        						'defaults' => array(
        								'controller' => 'Cli\Empty',
        								'action' => 'appcache'
        						),
        				),
        		),
	        ),
	    ),
	),
	'controllers' => array(
        'invokables' => array(
            'Cli\Create' => 'Cli\Controller\CreateController',
            'Cli\Empty' => 'Cli\Controller\EmptyController',
        ),
    ),
);
