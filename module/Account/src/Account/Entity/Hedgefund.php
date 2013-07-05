<?php
namespace Account\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Account\Model\HedgefundRepository")
 * @ORM\Table(name="Hedgefunds")
 */
class Hedgefund
{	
	
	/**
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @ORM\OneToMany(targetEntity="Payment\Entity\Product", mappedBy="hedgefund")
	 */
	private $products;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $title;
	
	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $description;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $regDate;
	
	
	
	public function __construct(){
		$this->products = new ArrayCollection();
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
	public function getProducts()
	{
	    return $this->products;
	}

	/**
	 * 
	 * @param Product $product
	 * @return Hedgefund
	 */
	public function setProduct(Product $product)
	{
	    $this->product = $product;
	    return $this;
	}

	/**
	 * 
	 * @return String
	 */
	public function getTitle()
	{
	    return $this->title;
	}

	/**
	 * 
	 * @param String $title
	 * @return Hedgefund
	 */
	public function setTitle(String $title)
	{
	    $this->title = $title;
	    return $this;
	}

	/**
	 * 
	 * @return String
	 */
	public function getDescription()
	{
	    return $this->description;
	}

	/**
	 * 
	 * @param String $description
	 * @return Hedgefund
	 */
	public function setDescription(String $description)
	{
	    $this->description = $description;
	    return $this;
	}

	/**
	 * 
	 * @return \Date 
	 */
	public function getRegDate()
	{
	    return $this->regDate;

	}

	/**
	 * @return Hedgefund
	 * @param \Date $regDate
	 */
	public function setRegDate(\Date $regDate)
	{
	    $this->regDate = $regDate;
	    return $this;
	}
}