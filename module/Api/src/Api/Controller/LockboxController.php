<?php
namespace Api\Controller;

use Account\Entity\BankAccountHistory;

use Account\Entity\User;

use Zend\View\Model\JsonModel;
use Extend\RestAction;

class LockboxController extends RestAction
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
		/* @var $user User */
		$user = $this->getEntityManager()->merge($this->getIdentity());
		if(!isset($data['amount']))
			$ret['error'] = array('code'=>'403','message'=>'Required data missing');
		elseif(!is_numeric($data['amount']))
			$ret['error'] = array('code'=>'403','message'=>'The amount is not a number (nAn)'." : ".$data["amount"]);
		elseif($this->getIdentity()->getLockboxAmount() <  $data['amount'])
			$ret['error'] = array('code'=>'403','message'=>'The balance is insufficient');
		elseif($this->getEntityManager()->getRepository("Account\Entity\BankAccount")->findOneBy(array("user"=>$user->getId(), "verified"=>true)) == null)
			$ret['error'] = array('code'=>'403','message'=>'User has no verified bank account');
		else
		{
			$bankAccount = $this->getEntityManager()->getRepository("Account\Entity\BankAccount")->findOneBy(array("user"=>$user->getId(), "verified"=>true));
			//Create an output action
			$history = new BankAccountHistory();
			$this->getEntityManager()->persist($history);
			$history->setAmount($data["amount"])->setAction(BankAccountHistory::BANK_OUTPUT)->setDate(new \DateTime())->setUser($user)->setBankAccount($bankAccount);
			//Debit
			$user->setLockboxAmount( ($user->getLockboxAmount()-$data['amount']) );
			$this->getEntityManager()->flush();
			$ret["message"] = "successful debited";
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
