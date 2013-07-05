<?php
namespace Account\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Account\Model\UserRepository")
 * @ORM\Table(name="Users")
 */
class User
{	
	const USER_ROLE_GUEST  = 0;
	const USER_ROLE_BANNED = 1;
	const USER_ROLE_NORMAL = 2;
	const USER_ROLE_ADMIN  = 3;
	
	/**
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string")
	 */
	private $clientNumber;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $role;

	/**
	 * @ORM\Column(type="string")
	 */
	private $firstName;

	/**
	 * @ORM\Column(type="string")
	 */
	private $lastName;

	/**
	 * @ORM\Column(type="string")
	 */
	private $phone;

	/**
	 * @ORM\Column(type="string")
	 */
	private $email;
	
	/**
	 * @ORM\Column(type="string")
	 */
	private $password;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $registerDate;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $verified = false;
	
	/**
	 * @ORM\Column(type="string")
	 */
	private $validationCode;

	/**
	 * @ORM\Column(type="date")
	 */
	private $birthDate;

	/**
	 * @ORM\Column(type="string")
	 */
	private $locale;

	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	private $lockboxAmount = 0.00;
	
	/**
	 * @ORM\OneToMany(targetEntity="Account\Entity\BankAccount", mappedBy="user")
	 */
	private $bankAccounts;

	/**
	 * @ORM\OneToMany(targetEntity="Account\Entity\AuthToken", mappedBy="user")
	 */
	private $authTokens;

	/**
	 * @ORM\OneToMany(targetEntity="Account\Entity\Investment", mappedBy="user")
	 */
	private $investments;

	/**
	 * @ORM\OneToMany(targetEntity="Account\Entity\BankAccountHistory", mappedBy="user")
	 */
	private $bankHistory;
	
	public function __construct()
	{
		$this->bankAccounts = new ArrayCollection();
		$this->authTokens = new ArrayCollection();
		$this->investments = new ArrayCollection();
		$this->bankHistory = new ArrayCollection();
	}

	
	public function getId() {
	    return $this->id;
	}
	
	/**
	 *
	 * @return User
	 */
	public function setId($id) {
	    $this->id = $id;
	    return $this;
	}

	
	public function getClientNumber() {
	    return $this->clientNumber;
	}
	
	/**
	 *
	 * @return User
	 */
	public function setClientNumber($clientNumber) {
	    $this->clientNumber = $clientNumber;
	
	    return $this;
	}

	
	public function getRole() {
	    return $this->role;
	}
	
	/**
	 *
	 * @return User
	 */
	public function setRole($role) {
	    $this->role = $role;
	    return $this;
	}

	
	public function getFirstName() {
	    return $this->firstName;
	}
	
	/**
	 *
	 * @return User
	 */	
	public function setFirstName($firstName) {
	    $this->firstName = $firstName;
	    return $this;
	}

	
	public function getLastName() {
	    return $this->lastName;
	}
	
	/**
	 *
	 * @return User
	 */	
	public function setLastName($lastName) {
	    $this->lastName = $lastName;
	    return $this;
	}

	
	public function getPhone() {
	    return $this->phone;
	}
	
	/**
	 *
	 * @return User
	 */	
	public function setPhone($phone) {
	    $this->phone = $phone;
	    return $this;
	}


	
	public function getEmail() {
	    return $this->email;
	}
	
	/**
	 *
	 * @return User
	 */
	public function setEmail($email) {
	    $this->email = $email;
	
	    return $this;
	}

	
	public function getPassword() {
	    return $this->password;
	}
	
	/**
	 *
	 * @return User
	 */
	public function setPassword($password) {
	    $this->password = $password;
	
	    return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getRegisterDate() {
	    return $this->registerDate;
	}
	
	/**
	 * @param \DateTime $registerDate
	 * @return User
	 */
	public function setRegisterDate(\DateTime $registerDate) {
	    $this->registerDate = $registerDate;
	    return $this;
	}

	
	public function isVerified() {
	    return $this->verified;
	}
	
	/**
	 *
	 * @return User
	 */
	public function setVerified($verified) {
	    $this->verified = $verified ? true : false;
	    return $this;
	}

	
	public function getValidationCode() {
	    return $this->validationCode;
	}
	
	/**
	 *
	 * @return User
	 */
	public function setValidationCode($validationCode) {
	    $this->validationCode = $validationCode;
	    return $this;
	}

	/**
	 * @return \Date
	 */
	public function getBirthDate() {
	    return $this->birthDate;
	}
	
	/**
	 * @param \Date $newbirthDate
	 * @return User
	 */
	public function setBirthDate(\Date $birthDate) {
	    $this->birthDate = $birthDate;
	    return $this;
	}

	
	public function getLocale() {
	    return $this->locale;
	}
	
	/**
	 *
	 * @return User
	 */
	public function setLocale($locale) {
	    $this->locale = $locale;
	    return $this;
	}

	
	public function getLockboxAmount() {
	    return $this->lockboxAmount;
	}
	
	/**
	 *
	 * @return User
	 */
	public function setLockboxAmount($lockboxAmount) {
	    $this->lockboxAmount = $lockboxAmount;
	    return $this;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getBankAccounts() {
	    return $this->bankAccounts;
	}
	
	/**
	 * @param BankAccount
	 * @return User
	 */
	public function addBankAccount(BankAccount $bankAccount) {
	    $this->bankAccounts->add($bankAccount);
	
	    return $this;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getAuthTokens() {
	    return $this->authTokens;
	}
	
	/**
	 * @param AuthToken
	 * @return User
	 */
	public function addAuthToken(AuthToken $authToken) {
	    $this->authTokens->add($authToken);
	    return $this;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getInvestments() {
	    return $this->investments;
	}
	
	/**
	 * @param Investment
	 * @return User
	 */
	public function setInvestments(Investment $investment) {
	    $this->investments->add($investment);
	    return $this;
	}

	/**
	 * 
	 * @return ArrayCollection
	 */
	public function getBankHistory()
	{
	    return $this->bankHistory;
	}

	/**
	 * 
	 * @param $bankHistory
	 * @return User
	 */
	public function addBankHistory(BankAccountHistory $bankHistory)
	{
		$this->bankHistory->add($bankHistory);
	}
	    
	    
} 