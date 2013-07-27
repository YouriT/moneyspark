<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Api;
use Account\Model\AuthStorage;
use DoctrineModule\Authentication\Adapter\ObjectRepository;
use Zend\Authentication\AuthenticationService;
use Account\Model\AuthServiceApi;


return array(
    'router' => array(
        'routes' => array(
            'api' => array(
                'type' => 'hostname',
                'options' => array(
                    'route'    => 'api.reonin.com',
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Api',
                        'controller' => 'Error',
                    ),
                ),
            	'may_terminate' => true,
            	'child_routes' => array(
            		'default' => array(
            			'type' => 'literal',
            			'options' => array(
            				'route' => '/',
            				'defaults' => array(
            					'__NAMESPACE__' => 'Api',
            					'controller' => 'Error',
            				)
            			)
            		),
            		'error' => array(
            			'type' => 'literal',
            			'options' => array(
            				'route' => '/error',
            				'defaults' => array(
            					'__NAMESPACE__' => 'Api',
            					'controller' => 'Error',
            				)
            			)
            		),
            		'rest' => array(
            			'type' => 'segment',
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
            'Api\Index' => 'Api\Controller\IndexController',
        	'Api\Error' => 'Api\Controller\ErrorController',
        	'Api\Auth' => 'Api\Controller\AuthController',
        	'Api\Investment' => 'Api\Controller\InvestmentController',
        	'Api\Lockbox' => 'Api\Controller\LockboxController',
        	'Api\Product' => 'Api\Controller\ProductController',
        	'Api\Profile' => 'Api\Controller\ProfileController',
        	'Api\Auth' => 'Api\Controller\AuthController',
        	'Api\Register' => 'Api\Controller\RegisterController',
        	'Api\Config' => 'Api\Controller\ConfigController'
        ),
    ),
	'controller_plugins' => array(
		'invokables' => array(
			'AuthAcl' => 'Account\Model\AuthAcl'
		),
	),
	'service_manager' => array(
		'factories' => array(
			'AuthStorage' => function ($sm) {
				return new AuthStorage('moneyspark');
			},
			'AuthService' => function ($sm) {
				$em = $sm->get('doctrine.entitymanager.orm_default');
				$authAdapter = new ObjectRepository(array(
					'objectManager' => $em,
					'objectRepository' => $em->getRepository('Account\Entity\User'),
					'identityClass' => 'Account\Entity\User',
					'identityProperty' => 'email',
					'credentialProperty' => 'password',
					'credentialCallable' => function ($identity, $cred)
					{
						return sha1($cred);
					}
				));
				$authService = new AuthenticationService();
				$authService->setAdapter($authAdapter)->setStorage($sm->get('AuthStorage'));
				return $authService;
			},
			'AuthServiceApi' => function ($sm) {
				return new AuthServiceApi($sm);
			}
		)
	),
	'view_manager' => array(
		'strategies' => array(
				'ViewJsonStrategy',
		),
		'template_path_stack' => array(
			'api' => __DIR__ . '/../view',
		)
	),
);
