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
	 * @ORM\OneToMany(targetEntity="Account\Entity\Product", mappedBy="hedgefund")
	 */
	private $products;
	
	/**
	 * @ORM\Column(type="string")
	 */
	private $title;
	
	/**
	 * @ORM\Column(type="string")
	 */
	private $logo;
	
	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $description;
	
	/**
	 * @ORM\Column(type="datetime")
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
	public function addProduct(Product $product)
	{
	    $this->product->add($product);
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
	public function setTitle($title)
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
	public function setDescription($description)
	{
	    $this->description = $description;
	    return $this;
	}

	/**
	 * 
	 * @return \DateTime
	 */
	public function getRegDate()
	{
	    return $this->regDate;

	}

	/**
	 * @return Hedgefund
	 * @param \DateTime $regDate
	 */
	public function setRegDate(\DateTime $regDate)
	{
	    $this->regDate = $regDate;
	    return $this;
	}
	
	public function getLogo() {
	    return $this->logo;
	}
	
	/**
	 * @return Hedgefund
	 */
	public function setLogo($logo) {
	    $this->logo = $logo;
	
	    return $this;
	}
	
	public function toArray(){
		return get_object_vars($this);
	}
}