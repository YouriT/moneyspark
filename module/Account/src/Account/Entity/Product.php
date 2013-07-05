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
	 * @ORM\Column(type="datetime")
	 */
	private $dateBeginExpected;

	/**
	 * @ORM\Column(type="datetime")
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
	 * @ORM\Column(type="integer")
	 */
	private $maxPeople = 99;
	
	/**
	 * @ORM\Column(type="string")
	 */
	private $prospectus;

	/**
	 * @ORM\ManyToOne(targetEntity="Account\Entity\Hedgefund", inversedBy="products")
	 */
	private $hedgefund;

	/**
	 * @ORM\OneToMany(targetEntity="Account\Entity\ProductTranslate", mappedBy="product")
	 */
	private $translations;

	/**
	 * @ORM\OneToMany(targetEntity="Account\Entity\ProductHistory", mappedBy="history")
	 */
	private $history;

	/**
	 * @ORM\OneToMany(targetEntity="Account\Entity\Investment", mappedBy="product")
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
	public function setRequiredAmount($requiredAmount)
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
	public function setProfitsRateExpected($profitsRateExpected)
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
	public function setLossRateExpected($lossRateExpected)
	{
		$this->lossRateExpected = $lossRateExpected;
		return $this;
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function getDateBeginExpected()
	{
		return $this->dateBeginExpected;
	}



	/**
	 *
	 * @param \DateTime $dateBeginExpected
	 * @return Product
	 */
	public function setDateBeginExpected(\DateTime $dateBeginExpected)
	{
		$this->dateBeginExpected = $dateBeginExpected;
		return $this;
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function getDateEndExpected()
	{
		return $this->dateEndExpected;
	}

	/**
	 *
	 * @param \DateTime $dateEndExpected
	 * @return Product
	 */
	public function setDateEndExpected(\DateTime $dateEndExpected)
	{
		$this->dateEndExpected = $dateEndExpected;
		return $this;
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function getDateBeginReal()
	{
		return $this->dateBeginReal;
	}

	/**
	 *
	 * @param \DateTime $dateBeginReal
	 * @return Product
	 */
	public function setDateBeginReal(\DateTime $dateBeginReal)
	{
		$this->dateBeginReal = $dateBeginReal;
		return $this;
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function getDateEndReal()
	{
		return $this->dateEndReal;
	}

	/**
	 *
	 * @param \DateTime $dateEndReal
	 * @return Product
	 */
	public function setDateEndReal(\DateTime $dateEndReal)
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
	public function setRentabilityAchieved($rentabilityAchieved)
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
	public function setMaxPeople($maxPeople)
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
	 * @return ArrayCollection
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
	 * @return ArrayCollection
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
	public function addHistory(ProductHistory $history)
	{
		$this->history->add($history);
		return $this;
	}

	/**
	 *
	 * @return ArrayCollection
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
	public function addInvestment(Investment $investment)
	{
		$this->investments->add($investment);
		return $this;
	}

	public function getProspectus() {
	    return $this->prospectus;
	}
	
	/**
	 * @return Product
	 */
	public function setProspectus($prospectus) {
	    $this->prospectus = $prospectus;
	
	    return $this;
	}
	
	
	/**
	 * @param String $locale
	 * @return ProductTranslate
	 */
	public function getTranslation($locale){
		$translations = $this->getTranslations();
		$ex = explode('_', $locale);
		$langUser = $ex[0];
		$def = null;
		$best = null;
		/* @var $t ProductTranslate */
		foreach ($translations as $t){
			$ex = explode('_', $t->getLocale());
			$lang = $ex[0];
			if($t->isDefault())
				$def = $t;
			if($lang == $langUser)
				$best = $t;
		}
		$best == null ? $r = $def : $r = $best;
		return $r;
	}
	
	public function toArray(){
		return get_object_vars($this);
	}
	
}