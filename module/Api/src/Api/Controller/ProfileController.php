<?php
namespace Api\Controller;

use Account\Model\Utilities;

use Zend\View\Model\JsonModel;
use Extend\RestAction;

class ProfileController extends RestAction
{
	public function getList()
	{
		return new JsonModel();
	}
	
	public function get($id)
	{
		if($id=="me"){
			$params["averageRentability"] = $this->getEntityManager()->getRepository("Account\Entity\Investment")->getRentabilityAverage($this->getIdentity());
			$params["maxFeeRate"] = Utilities::MAX_FEERATE;
			$params["minFeeRate"] = Utilities::MIN_FEERATE;
		
		return new JsonModel($params);
		}
		else
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
