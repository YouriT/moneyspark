<?php
namespace Api\Controller;


use Zend\View\Model\ConsoleModel;

use Extend\Action;


class CreateController extends Action
{
	private $console;
	
	/**
	 * 
	 * @return ConsoleModel
	 */
	private function getConsole()
	{
		if(!$this->console)
		{
			$this->console = $this->getServiceLocator()->get("console");
		}
		return $this->console;
	}
	
	public function appcacheAction()
	{
		$this->getConsole()->writeLine("coucou");
	}
	
	
}
