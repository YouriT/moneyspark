<?php
namespace Cli\Controller;


use Zend\View\Model\ConsoleModel;

use Extend\Action;

class EmptyController extends Action
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
		//Empty cache
		$str="CACHE MANIFEST\r\n# Version ".time()."\r\n";
		$str .= "\r\nNETWORK:\r\n*";
		file_put_contents(getcwd()."/public/mobile/.appcache", $str);
		$this->getConsole()->writeLine("Empty appcache : finished");
	}
	
	
}
