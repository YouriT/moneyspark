<?php
namespace Account\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Account\Model\BankAccountHistoryRepository")
 * @ORM\Table(name="BankAccountsHistory")
 */
class BankAccountHistory
{
	const BANK_INPUT = 0;
	const BANK_OUTPUT = 1;
	
	/**
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Account\Entity\User", inversedBy="bankHistory")
	 */
	private $user;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $action;

	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	private $amount;

	/**
	 * @ORM\ManyToOne(targetEntity="Account\Entity\BankAccount", inversedBy="history")
	 */
	private $bankAccount;

	/**
	 * @ORM\ManyToOne(targetEntity="Account\Entity\Investment", inversedBy="history")
	 */
	private $investment;

	
	public function getId() {
	    return $this->id;
	}
	
	/**
	 * @return BankAccountHistory
	 */
	public function setId($id) {
	    $this->id = $id;
	
	    return $this;
	}

	/**
	 * @return User
	 */
	public function getUser() {
	    return $this->user;
	}
	
	/**
	 * @param User
	 * @return BankAccountHistory
	 */
	public function setUser(User $user) {
	    $this->user = $user;
	
	    return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate() {
	    return $this->date;
	}
	
	/**
	 * @param \DateTime
	 * @return BankAccountHistory
	 */
	public function setDate(\DateTime $date) {
	    $this->date = $date;
	
	    return $this;
	}

	
	public function getAction() {
	    return $this->action;
	}
	
	/**
	 * @return BankAccountHistory
	 */
	public function setAction($action) {
	    $this->action = $action;
	
	    return $this;
	}

	
	public function getAmount() {
	    return $this->amount;
	}
	
	/**
	 * @return BankAccountHistory
	 */	
	public function setAmount($amount) {
	    $this->amount = $amount;
	
	    return $this;
	}

	/**
	 * @return BankAccount
	 */
	public function getBankAccount() {
	    return $this->bankAccount;
	}
	
	/**
	 * @param BankAccount $newbankAccount
	 */
	public function setBankAccount(BankAccount $bankAccount) {
	    $this->bankAccount = $bankAccount;
	
	    return $this;
	}

	/**
	 * @return Investment
	 */
	public function getInvestment() {
	    return $this->investment;
	}
	
	/**
	 * @param Investment $newinvestment
	 * @return BankAccountHistory
	 */
	public function setInvestment(Investment $investment) {
	    $this->investment = $investment;
	
	    return $this;
	}
}