<?php

namespace Account\Entity;

use Account\Entity\ProductHistory;



use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Account\Model\ProductHistoryRepository")
 * @ORM\Table(name="ProductsHistory")
 */
class ProductHistory
{	
	/**
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Account\Entity\Product", inversedBy="investments")
	 */
	private $product;
	
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date;
	
	/**
	 * @ORM\Column(type="decimal", precision=3, scale=2)
	 */
	private $currentRate;
	
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
	 * @return Product
	 */
	public function getProduct()
	{
	    return $this->product;
	}

	/**
	 * 
	 * @param Product $product
	 * @return ProductHistory
	 */
	public function setProduct(Product $product)
	{
	    $this->product = $product;
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
	 * @return ProductHistory
	 */
	public function setDate(\DateTime $date)
	{
	    $this->date = $date;
	    return $this;
	}

	/**
	 * 
	 * @return Double
	 */
	public function getCurrentRate()
	{
	    return $this->currentRate;
	}

	/**
	 * 
	 * @param Double $currentRate
	 * @return ProductHistory
	 */
	public function setCurrentRate($currentRate)
	{
	    $this->currentRate = $currentRate;
	    return $this;
	}
}