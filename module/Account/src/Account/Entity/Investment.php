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
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @ORM\OneToMany(targetEntity="Account\Entity\BankAccountHistory", mappedBy="investment")
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
	 * @ORM\Column(type="datetime")
	 */
	private $date;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $ended;
	
	/**
	 * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
	 */
	private $rentabilityAchieved;
	
	/**
	 * @ORM\Column(type="decimal", precision=3, scale=2)
	 */
	private $fee;
	
	public function __construct(){
		$this->history = new ArrayCollection();
	}
	
	/**
	 *
	 * @return Integer
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * 
	 * @return ArrayCollection
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
	public function addHistory(BankAccountHistory $history)
	{
	    $this->history->add($history);
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
	 * @return Investment
	 */
	public function setProduct(Product $product)
	{
	    $this->product = $product;
	    return $this;
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
	public function setAmount($amount)
	{
	    $this->amount = $amount;
	    return $this;
	}

	/**
	 * 
	 * @return \DateTime
	 */
	public function getDate()
	{
	    return $this->date;
	}

	/**
	 * 
	 * @param \DateTime $date
	 * @return Investment
	 */
	public function setDate(\DateTime $date)
	{
	    $this->date = $date;
	    return $this;
	}

	/**
	 * 
	 * @return \DateTime
	 */
	public function getEnded()
	{
	    return $this->ended;
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function isEnded()
	{
		return $this->ended != null ? true : false;
	}
	


	/**
	 * 
	 * @param \DateTime $ended
	 * @return Investment
	 */
	public function setEnded(\DateTime $ended)
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
	public function setRentabilityAchieved($rentabilityAchieved)
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
	public function setFee($fee)
	{
	    $this->fee = $fee;
	    return $this;
	}
}