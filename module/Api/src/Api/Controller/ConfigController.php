<?php
namespace Api\Controller;

use Account\Model\Utilities;
use Extend\RestAction;

class ConfigController extends RestAction
{
	public function getList()
	{
		$params = array();
		$params["maxFeeRate"] = Utilities::MAX_FEERATE;
		$params["minFeeRate"] = Utilities::MIN_FEERATE;
		return $this->getJsonModel($params);
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
