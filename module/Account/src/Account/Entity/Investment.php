<?php
namespace Account\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Account\Model\InvestmentRepository")
 * @ORM\Table(name="Investments")
 */
class Investment
{	
	
	/**
	 * @ORM\OneToMany(targetEntity="Payment\Entity\BankAccountHistory", mappedBy="investment")
	 */
	private $history;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Account\Entity\Product", inversedBy="investments")
	 */
	private $product;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Account\Entity\User", inversedBy="investments")
	 */
	private $user;
	
	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	private $amount = 0;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $date;
	
	
	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $ended = false;
	
	
	/**
	 * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
	 */
	private $rentabilityAchieved;
	
	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
	 */
	private $fee;
	
	
	
	public function __construct(){
		$this->history = new ArrayCollection();
	}
	

	/**
	 * 
	 * @return BankAccountHistory
	 */
	public function getHistory()
	{
	    return $this->history;
	}

	/**
	 * 
	 * @param BankAccountHistory $history
	 * @return Investment
	 */
	public function setHistory(BankAccountHistory $history)
	{
	    $this->history = $history;
	    return $this;
	}

	/**
	 * 
	 * @return Product
	 */
	public function getProduct()
	{
	    return $this->product;
	}

	/**
	 * 
	 * @param Product $product
	 * @return Product
	 */
	public function setProduct(Product $product)
	{
	    $this->product = $product;
	}

	/**
	 * 
	 * @return User
	 */
	public function getUser()
	{
	    return $this->user;
	}

	/**
	 * 
	 * @param User $user
	 * @return Investment
	 */
	public function setUser(User $user)
	{
	    $this->user = $user;
	    return $this;
	}

	/**
	 * 
	 * @return Double
	 */
	public function getAmount()
	{
	    return $this->amount;
	}

	/**
	 * 
	 * @param $amount
	 * @return Investment
	 */
	public function setAmount(Double $amount)
	{
	    $this->amount = $amount;
	    return $this;
	}

	/**
	 * 
	 * @return \Date
	 */
	public function getDate()
	{
	    return $this->date;
	}

	/**
	 * 
	 * @param \Date $date
	 * @return Investment
	 */
	public function setDate(\Date $date)
	{
	    $this->date = $date;
	    return $this;
	}

	/**
	 * 
	 * @return boolean
	 */
	public function isEnded()
	{
	    return $this->ended;
	}

	/**
	 * 
	 * @param boolean $ended
	 * @return Investment
	 */
	public function setEnded(boolean $ended)
	{
	    $this->ended = $ended;
	    return $this;
	}

	/**
	 * 
	 * @return Double
	 */
	public function getRentabilityAchieved()
	{
	    return $this->rentabilityAchieved;
	}

	/**
	 * 
	 * @param Double $rentabilityAchieved
	 * @return Investment
	 */
	public function setRentabilityAchieved(Double $rentabilityAchieved)
	{
	    $this->rentabilityAchieved = $rentabilityAchieved;
	    return $this;
	}

	/**
	 * 
	 * @return Double
	 */
	public function getFee()
	{
	    return $this->fee;
	}

	/**
	 * 
	 * @param Double $fee
	 * @return Investment
	 */
	public function setFee(Double $fee)
	{
	    $this->fee = $fee;
	    return $this;
	}
}