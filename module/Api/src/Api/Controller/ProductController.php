<?php
namespace Api\Controller;

use Account\Entity\Product;

use Zend\View\Model\JsonModel;
use Extend\RestAction;

class ProductController extends RestAction
{
	public function getList()
	{
		/* @var $p Product */
		foreach($this->getEntityManager()->getRepository("Account\Entity\Product")->getDisplayable(false) as $p){
			//Info translation
			$details = $p->getTranslation("fr_BE")->toArray();
			//Info investments
			$investedAmount = array("sumInvestedAmounts"=>$this->getEntityManager()->getRepository("Account\Entity\Investment")->getSumInvestedAmounts($p));
			//Info hedgefund
			$hedgefund = $p->getHedgefund()->toArray();
			$current["product"] = array_merge($details,$p->toArray(), $investedAmount);
			unset($current['product']['product'], 
				  $current['product']['translations'], 
				  $current['product']['locale'], 
				  $current['product']['default'],
				  $current['product']['hedgefund'],
				  $current['product']['history'],
				  $current['product']['__isInitialized__']);
			$current["hedgefund"] = $hedgefund;
			unset($current['hedgefund']['products'],
				  $current['hedgefund']['__isInitialized__']);
			$total[] = $current;
		}
		$json = new JsonModel($total);
		return var_dump(json_decode($json->serialize()));
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
