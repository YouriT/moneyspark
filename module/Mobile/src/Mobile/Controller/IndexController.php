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
	private $view;
	
	private function getView() {
		if (!$this->view) {
			$this->view = new ViewModel();
			if ($this->request->isXmlHttpRequest())
				$this->view->setTerminal(true);
		}
		return $this->view;
	}
    public function indexAction()
    {
        return new ViewModel();
    }
    public function aboutAction()
    {
    	return $this->getView();
    }
    public function buyAction()
    {
    	return $this->getView();
    }
    public function cash1Action()
    {
    	return $this->getView();
    }
    public function cash2Action()
    {
    	return $this->getView();
    }
    public function cash3Action()
    {
    	return $this->getView();
    }
    public function confirmationAction()
    {
    	return $this->getView();
    }
    public function confirmationdealAction()
    {
    	return $this->getView();
    }
    public function connexionAction()
    {
    	return $this->getView();
    }
    public function signinAction()
    {
    	return $this->getView();
    }
    public function userprofileAction()
    {
    	return $this->getView();
    }
}
