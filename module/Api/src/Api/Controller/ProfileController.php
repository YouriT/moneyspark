<?php
namespace Api\Controller;

use Account\Model\Utilities;

use Zend\View\Model\JsonModel;
use Extend\RestAction;

class ProfileController extends RestAction
{
	public function getList()
	{
		return $this->getJsonModel();
	}
	
	public function get($id)
	{
		$params = array();
		if($id=="me"){
			$params["averageRentability"] = $this->getEntityManager()->getRepository("Account\Entity\Investment")->getRentabilityAverage($this->getIdentity());
			$params["maxFeeRate"] = Utilities::MAX_FEERATE;
			$params["minFeeRate"] = Utilities::MIN_FEERATE;
		}
		return $this->getJsonModel($params);
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
