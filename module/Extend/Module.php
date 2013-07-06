<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Extend;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Extend\Mail\Service\SmtpTransportFactory;
use Extend\Mail\Service\MessageFactory;
use Extend\Service\Mailer;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    public function getServiceConfig()
    {
    	return array(
			'shared' => array(
				'common.mailer.default_message' => false
			),
    		'factories'  => array(
				'common.mailer.smtp_transport'  => new SmtpTransportFactory(),
				'common.mailer.default_message' => new MessageFactory(),
    			'common.service.mailer' => function ($sm)
    			{
    				$mailer = new Mailer();
    				$mailer->setServiceManager($sm);
    				return $mailer;
    			}
    		),
    	);
    }

    public function getConfig()
    {
        return array();
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
