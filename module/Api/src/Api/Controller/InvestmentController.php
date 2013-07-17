<?php
namespace Api\Controller;

use Account\Entity\ProductHistory;

use Account\Entity\User;

use Account\Model\Utilities;

use Account\Entity\Product;

use Account\Entity\Investment;

use Account\Entity\BankAccountHistory;

use Zend\View\Model\JsonModel;
use Extend\RestAction;

class InvestmentController extends RestAction
{
	public function getList()
	{
		/* @var $i Investment */
		foreach($this->getEntityManager()->getRepository("Account\Entity\Investment")->getTotal($this->getIdentity()) as $i){
			
			/* @var $p Product */
			$p = $i->getProduct();
			
			/* @var $lastKnownRentability ProductHistory */
			if($i->getRentabilityAchieved() == null){
				$lastKnownRentability = $this->getEntityManager()->getRepository("Account\Entity\ProductHistory")->getLast($p);
				if($lastKnownRentability == null)
					$array['rentability'] = 0;
				else
					$array['rentability'] = $lastKnownRentability->getCurrentRate();
			}
			else
				$array['rentability'] = $i->getRentabilityAchieved();
			
			
			$array['product'] = $p->getTranslation($this->getIdentity()->getLocale())->toArray();
			$array['hedgefund'] = $hedgefund = $p->getHedgefund()->toArray();
			$array['amount'] = $i->getAmount();
			

			
			if($i->isEnded())
				$ret["ended"][] = $array;
			elseif($p->getDateBeginExpected() > new \DateTime())
				$ret["notStarted"][] = $array;
			else
				$ret["current"][] = $array;
		}
		return $this->getJsonModel($ret);
	}
	
	public function get($id)
	{
		return $this->getJsonModel();
	}
	
	public function create($data)
	{
		/* @var $user User */
		$user = $this->getEntityManager()->merge($this->getIdentity());
		if(!isset($data['idProduct']) || !isset($data['amount']))
			$ret['error'] = array('code'=>'403','message'=>'Required data missing');
		elseif(!is_numeric($data['amount']))
			$ret['error'] = array('code'=>'403','message'=>'The amount is not a number (nAn)'." : ".$data["amount"]);
		elseif($this->getEntityManager()->find("Account\Entity\Product", $data['idProduct']) == null)
			$ret['error'] = array('code'=>'403','message'=>'This financial product does not exist');
		elseif($this->getIdentity()->getLockboxAmount() <  $data['amount'])
			$ret['error'] = array('code'=>'403','message'=>'The balance is insufficient');
		elseif($this->getEntityManager()->getRepository("Account\Entity\BankAccount")->findOneBy(array("user"=>$user->getId(), "verified"=>true)) == null)
			$ret['error'] = array('code'=>'403','message'=>'User has no verified bank account');
		elseif($data['amount'] <= 0)
			$ret['error'] = array('code'=>'403','message'=>'The amount is insufficient');
		else
		{
			/* @var $product Product */
			$product = $this->getEntityManager()->find("Account\Entity\Product", $data['idProduct']);
			$bankAccount = $this->getEntityManager()->getRepository("Account\Entity\BankAccount")->findOneBy(array("user"=>$user->getId(), "verified"=>true));
			//Create an investment
			$investment = new Investment();
			$this->getEntityManager()->persist($investment);
			//Create an output action
			$history = new BankAccountHistory();
			$this->getEntityManager()->persist($history);
			$history->setAmount($data["amount"])->setAction(BankAccountHistory::BANK_OUTPUT)->setDate(new \DateTime())->setUser($user)->setInvestment($investment)->setBankAccount($bankAccount);
			//How much fee ?
			$sumOfInvestedAmounts = $this->getEntityManager()->getRepository("Account\Entity\Investment")->getSumInvestedAmounts($product);
			$requiredAmount = $product->getRequiredAmount();
			$ratioInvested = round($sumOfInvestedAmounts/$requiredAmount, 2);
			if($ratioInvested>1)$ratioInvested=1;
			$diff = Utilities::MAX_FEERATE-Utilities::MIN_FEERATE;
			$feeRate = Utilities::MIN_FEERATE+($ratioInvested*$diff);
			$b = round($data["amount"]/100)*0.01;
			$feeRate-$b < Utilities::MIN_FEERATE ? $feeRate = Utilities::MIN_FEERATE : $feeRate = $feeRate-$b;
			$feeRate = round($feeRate,2);
			$investment->setProduct($product)->setDate(new \DateTime())->setAmount($data["amount"])->setFee($feeRate)->setUser($user);
			//Debit
			$user->setLockboxAmount( ($user->getLockboxAmount()-$data['amount']) );
			//Send Email
			
			$this->getEntityManager()->flush();
			$ret["message"] = "successful invested";
		}
		
		return $this->getJsonModel($ret);
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
