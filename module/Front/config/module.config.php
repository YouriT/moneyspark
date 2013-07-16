<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Front;

return array(
    'router' => array(
        'routes' => array(
            'front' => array(
                'type' => 'hostname',
                'options' => array(
                    'route'    => 'site.reonin.com',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Front',
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
                                '__NAMESPACE__' => 'Front',
                                'controller' => 'Index',
                            )
                        )
                    ),
                    'main' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Front\Index' => 'Front\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'Error/404',
        'exception_template'       => 'Error/index',
        'template_map' => array(
            'Front/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        	'Error/404'               => __DIR__ . '/../view/error/404.phtml',
        	'Error/index'             => __DIR__ . '/../view/error/index.phtml'
        ),
        'template_path_stack' => array(
        		'Front' => __DIR__ . '/../view',
        		'Mobile' => str_replace("Front", "Mobile", __DIR__) . '/../view'
        )
    ),
	'module_layouts' => array(
			'Front' => 'Front/layout',
	)
);


