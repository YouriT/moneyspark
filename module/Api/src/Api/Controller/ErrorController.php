<?php
namespace Api\Controller;

use Zend\View\Model\JsonModel;
use Extend\RestAction;

class ErrorController extends RestAction
{
	public function getList()
	{
		$arr = array('error'=>"You're not logged in");
		return $this->getJsonModel($arr);
	}
	
	public function get($id)
	{
		return $this->getJsonModel();
	}
	
	public function create($data)
	{
		return $this->getJsonModel();
	}
	
	public function update($id, $data)
	{
		return $this->getJsonModel();
	}
	
	public function delete($id)
	{
		return $this->getJsonModel();
	}
}
