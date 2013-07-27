<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Cli;

return array(
	'Console' => array(
	    'router' => array(
	        'routes' => array(
	            'cli-appcache' => array(
	                'options' => array(
	                    'route'    => 'create appcache',
	                    'defaults' => array(
	                        'controller' => 'Cli\Create',
	                    	'action' => 'appcache'
	                    ),
	                ),
	            ),
	        ),
	    ),
	    'controllers' => array(
	        'invokables' => array(
	            'Cli\Create' => 'Cli\Controller\CreateController',
	        ),
	    ),
));
