<?php
namespace Api\Controller;

use Account\Entity\Product;

use Zend\View\Model\JsonModel;
use Extend\RestAction;

class ProductController extends RestAction
{
	public function getList()
	{
		$total = array();
		/* @var $p Product */
		foreach($this->getEntityManager()->getRepository("Account\Entity\Product")->getDisplayable(false) as $p){
			//Info translation
			if($this->getIdentity() == null)
				$locale = $this->params()->fromQuery('locale',null);
			else
				$locale = $this->getIdentity()->getLocale();
			
			$details = $p->getTranslation($locale)->toArray();
			//Info investments
			$sumInvAm = $this->getEntityManager()->getRepository("Account\Entity\Investment")->getSumInvestedAmounts($p);
			$investedAmount = array("sumInvestedAmounts"=>$sumInvAm == null ? 0 : $sumInvAm);
			//Info hedgefund
			$hedgefund = $p->getHedgefund()->toArray();
			$current["product"] = array_merge($details,$p->toArray(), $investedAmount);
			$current["hedgefund"] = $hedgefund;
			$total[] = $current;
		}
		return $this->getJsonModel($total);
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
