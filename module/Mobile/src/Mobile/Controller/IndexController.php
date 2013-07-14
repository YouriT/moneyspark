<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Mobile\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Extend\Action;

class IndexController extends Action
{
    public function indexAction()
    {
        return new ViewModel();
    }
    public function aboutAction()
    {
    	return new ViewModel();
    }
    public function buyAction()
    {
    	return new ViewModel();
    }
    public function cash1Action()
    {
    	return new ViewModel();
    }
    public function cash2Action()
    {
    	return new ViewModel();
    }
    public function cash3Action()
    {
    	return new ViewModel();
    }
    public function confirmationAction()
    {
    	return new ViewModel();
    }
    public function confirmationdealAction()
    {
    	return new ViewModel();
    }
    public function connexionAction()
    {
    	return new ViewModel();
    }
    public function signinAction()
    {
    	return new ViewModel();
    }
    public function userprofileAction()
    {
    	return new ViewModel();
    }
}
