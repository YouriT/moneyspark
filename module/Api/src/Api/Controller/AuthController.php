<?php
namespace Api\Controller;

use Zend\View\Model\JsonModel;
use Extend\RestAction;

class AuthController extends RestAction
{
	public function getList()
	{
		return new JsonModel();
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
