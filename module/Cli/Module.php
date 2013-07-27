<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cli;

use Zend\Console\Adapter\AdapterInterface;

use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Account\Model\AuthStorage;
use DoctrineModule\Authentication\Adapter\ObjectRepository;
use Zend\Authentication\AuthenticationService;

class Module implements ConsoleUsageProviderInterface
{
	public function getConsoleUsage(AdapterInterface $console)
	{
		return array("create appcache"=>"Create an appcache file including all resources from public mobile directory");
	}
	
    public function onBootstrap(MvcEvent $e){}

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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
