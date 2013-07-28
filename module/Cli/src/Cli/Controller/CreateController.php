<?php
namespace Cli\Controller;


use Zend\View\Model\ConsoleModel;

use Extend\Action;

function files($dir, $prefix = '') {
  $dir = rtrim($dir, '\\/');
  $result = array();

    foreach (scandir($dir) as $f) {
      if ($f !== '.' and $f !== '..') {
        if (is_dir("$dir/$f")) {
          $result = array_merge($result, files("$dir/$f", "$prefix$f/"));
        } else {
          $result[] = $prefix.$f;
        }
      }
    }

  return $result;
}


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
		//Cache resources
		$b = "";
		$files = files(getcwd()."/public/mobile/");
		$str="CACHE MANIFEST\r\n# Version ".time()."\r\n";
		foreach($files as $f){
			if( (preg_match("#\.js#", $f) && !preg_match("#mobile\.min\.js#", $f)) || 
				(preg_match("#\.less#", $f)) || 
				(preg_match("#\.appcache#", $f)) || 
				(preg_match("#font#", $f)) ||
				(preg_match("#\.DS_Store#", $f))
			  )
				continue;
			else
				$str .= "\r\n".$b.$f;
		}
		//Cache html
		$str .= "\r\n/index";
		$str .= "\r\n/about";
		$str .= "\r\n/signin";
		$str .= "\r\n/userprofile";
		
		$str .= "\r\nNETWORK:\r\n*";
		
		file_put_contents(getcwd()."/public/mobile/.appcache", $str);
		$this->getConsole()->writeLine("Write appcache : finished");
	}
	
	
}
