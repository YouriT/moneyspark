<?php
namespace Account\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Account\Model\BankAccountRepository")
 * @ORM\Table(name="BankAccounts")
 */
class BankAccount
{
	/**
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Account\Entity\User", inversedBy="bankAccounts")
	 */
	private $user;

	/**
	 * @ORM\Column(type="string")
	 */
	private $iban;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $verified = false;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $deleted = false;

	/**
	 * @ORM\OneToMany(targetEntity="Account\Entity\BankAccountHistory", mappedBy="bankAccount")
	 */
	private $history;

	public function __construct()
	{
		$this->history = new ArrayCollection();
	}

	
	public function getId() {
	    return $this->id;
	}
	
	
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
	 */
	public function setUser(User $user) {
	    $this->user = $user;
	
	    return $this;
	}

	
	public function getIban() {
	    return $this->iban;
	}
	
	
	public function setIban($iban) {
	    $this->iban = $iban;
	
	    return $this;
	}

	
	public function isVerified() {
	    return $this->verified;
	}
	
	
	public function setVerified($verified) {
	    $this->verified = $verified ? true : false;
	
	    return $this;
	}

	
	public function isDeleted() {
	    return $this->deleted;
	}
	
	
	public function setDeleted($deleted) {
	    $this->deleted = $deleted ? true : false;
	
	    return $this;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getHistory() {
	    return $this->history;
	}
	
	
	public function addHistory(BankAccountHistory $history) {
	    $this->history->add($history);
	
	    return $this;
	}
}