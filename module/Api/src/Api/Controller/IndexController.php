<?php
namespace Api\Controller;

use Zend\View\Model\JsonModel;
use Extend\RestAction;

class IndexController extends RestAction
{
	public function getList()
	{
		return $this->getJsonModel();
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
