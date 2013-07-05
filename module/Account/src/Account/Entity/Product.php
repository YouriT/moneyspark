<?php

namespace Account\Entity;

use Account\Entity\Investment;

use Account\Entity\ProductTranslate;


use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Account\Model\ProductRepository")
 * @ORM\Table(name="Products")
 */
class Product
{
	/**
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	private $requiredAmount = 0;

	/**
	 * @ORM\Column(type="decimal", precision=3, scale=2)
	 */
	private $profitsRateExpected = 0;

	/**
	 * @ORM\Column(type="decimal", precision=3, scale=2)
	 */
	private $lossRateExpected = 0;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $dateBeginExpected;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $dateEndExpected;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $dateBeginReal;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $dateEndReal;

	/**
	 * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
	 */
	private $rentabilityAchieved;

	/**
	 * @ORM\Column(type="Integer")
	 */
	private $maxPeople = 99;

	/**
	 * @ORM\ManyToOne(targetEntity="Account\Entity\Hedgefund", inversedBy="products")
	 */
	private $hedgefund;

	/**
	 * @ORM\OneToMany(targetEntity="Payment\Entity\ProductTranslate", mappedBy="product")
	 */
	private $translations;

	/**
	 * @ORM\OneToMany(targetEntity="Payment\Entity\ProductHistory", mappedBy="history")
	 */
	private $history;

	/**
	 * @ORM\OneToMany(targetEntity="Payment\Entity\Investment", mappedBy="product")
	 */
	private $investments;


	public function __construct(){
		$this->translations = new ArrayCollection();
		$this->history = new ArrayCollection();
		$this->investments = new ArrayCollection();
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
	 * @return Double
	 */
	public function getRequiredAmount()
	{
		return $this->requiredAmount;
	}

	/**
	 *
	 * @param $requiredAmount
	 * @return Product
	 */
	public function setRequiredAmount(Double $requiredAmount)
	{
		$this->requiredAmount = $requiredAmount;
		return $this;
	}

	/**
	 *
	 * @return Double
	 */
	public function getProfitsRateExpected()
	{
		return $this->profitsRateExpected;
	}

	/**
	 *
	 * @param $profitsRateExpected
	 * @return Product
	 */
	public function setProfitsRateExpected(Double $profitsRateExpected)
	{
		$this->profitsRateExpected = $profitsRateExpected;
		return $this;
	}

	/**
	 *
	 * @return Double
	 */
	public function getLossRateExpected()
	{
		return $this->lossRateExpected;
	}

	/**
	 *
	 * @param $lossRateExpected
	 * @return Product
	 */
	public function setLossRateExpected(Double $lossRateExpected)
	{
		$this->lossRateExpected = $lossRateExpected;
		return $this;
	}

	/**
	 *
	 * @return \Date
	 */
	public function getDateBeginExpected()
	{
		return $this->dateBeginExpected;
	}



	/**
	 *
	 * @param \Date $dateBeginExpected
	 * @return Product
	 */
	public function setDateBeginExpected(\Date $dateBeginExpected)
	{
		$this->dateBeginExpected = $dateBeginExpected;
		return $this;
	}

	/**
	 *
	 * @return \Date
	 */
	public function getDateEndExpected()
	{
		return $this->dateEndExpected;
	}

	/**
	 *
	 * @param \Date $dateEndExpected
	 * @return Product
	 */
	public function setDateEndExpected(\Date $dateEndExpected)
	{
		$this->dateEndExpected = $dateEndExpected;
		return $this;
	}

	/**
	 *
	 * @return \Date
	 */
	public function getDateBeginReal()
	{
		return $this->dateBeginReal;
	}

	/**
	 *
	 * @param \Date $dateBeginReal
	 * @return Product
	 */
	public function setDateBeginReal(\Date $dateBeginReal)
	{
		$this->dateBeginReal = $dateBeginReal;
		return $this;
	}

	/**
	 *
	 * @return \Date
	 */
	public function getDateEndReal()
	{
		return $this->dateEndReal;
	}

	/**
	 *
	 * @param \Date $dateEndReal
	 * @return Product
	 */
	public function setDateEndReal(\Date $dateEndReal)
	{
		$this->dateEndReal = $dateEndReal;
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
	 * @param $rentabilityAchieved
	 * @return Hedgefund
	 */
	public function setRentabilityAchieved(Double $rentabilityAchieved)
	{
		$this->rentabilityAchieved = $rentabilityAchieved;
		return $this;
	}

	/**
	 *
	 * @return Integer
	 */
	public function getMaxPeople()
	{
		return $this->maxPeople;
	}

	/**
	 *
	 * @param $maxPeople
	 * @return Product
	 */
	public function setMaxPeople(Integer $maxPeople)
	{
		$this->maxPeople = $maxPeople;
		return $this;
	}

	/**
	 *
	 * @return Hedgefund
	 */
	public function getHedgefund()
	{
		return $this->hedgefund;
	}

	/**
	 *
	 * @param Hedgefund $hedgefund
	 * @return Product
	 */
	public function setHedgefund(Hedgefund $hedgefund)
	{
		$this->hedgefund = $hedgefund;
		return $this;
	}

	/**
	 *
	 * @return ProductTranslate
	 */
	public function getTranslations()
	{
		return $this->translations;
	}

	/**
	 *
	 * @param ProductTranslate $translations
	 * @return Product
	 */
	public function setTranslations(ProductTranslate $translations)
	{
		$this->translations = $translations;
		return $this;
	}

	/**
	 *
	 * @return ProductHistory
	 */
	public function getHistory()
	{
		return $this->history;
	}

	/**
	 *
	 * @param $history
	 * @return Product
	 */
	public function setHistory(ProductHistory $history)
	{
		$this->history = $history;
		return $this;
	}

	/**
	 *
	 * @return Investment
	 */
	public function getInvestments()
	{
		return $this->investments;
	}

	/**
	 *
	 * @param Investment $investments
	 * @return Product
	 */
	public function setInvestments(Investment $investments)
	{
		$this->investments = $investments;
		return $this;
	}
}