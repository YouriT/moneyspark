<?php
namespace Api\Controller;

use Zend\View\Model\JsonModel;
use Extend\RestAction;

class ErrorController extends RestAction
{
	public function getList()
	{
		$arr = array('error'=>"You're not logged in");
		return new JsonModel($arr);
	}
	
	public function get($id)
	{
		return new JsonModel();
	}
	
	public function create($data)
	{
		return new JsonModel();
	}
	
	public function update($id, $data)
	{
		return new JsonModel();
	}
	
	public function delete($id)
	{
		return new JsonModel();
	}
}
