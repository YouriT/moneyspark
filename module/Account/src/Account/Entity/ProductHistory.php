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
	 * @ORM\ManyToOne(targetEntity="Account\Entity\Product", inversedBy="investments")
	 */
	private $product;
	
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $date;
	
	/**
	 * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
	 */
	private $currentRate;
	

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
	 * @return \Date
	 */
	public function getDate()
	{
	    return $this->date;
	}

	/**
	 * 
	 * @param \Date $date
	 * @return ProductHistory
	 */
	public function setDate(\Date $date)
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
	public function setCurrentRate(Double $currentRate)
	{
	    $this->currentRate = $currentRate;
	    return $this;
	}
}