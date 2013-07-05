<?php
namespace Account\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Account\Model\ProductTranslateRepository")
 * @ORM\Table(name="ProductsTranslations")
 */
class ProductTranslate
{	
	
	
	/**
	 * @ORM\ManyToOne(targetEntity="Account\Entity\Product", inversedBy="translations")
	 */
	private $product;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $title;
	
	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $description;
	
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $locale;
	
	
	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $default = false;
	
	
	

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
	 * @return ProductTranslate
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
	 * @return ProductTranslate
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
	 * @return ProductTranslate
	 */
	public function setDescription(String $description)
	{
	    $this->description = $description;
	    return $this;
	}

	/**
	 * 
	 * @return String
	 */
	public function getLocale()
	{
	    return $this->locale;
	}

	/**
	 * 
	 * @param String $locale
	 * @return ProductTranslate
	 */
	public function setLocale(String $locale)
	{
	    $this->locale = $locale;
	    return $this;
	}

	/**
	 * 
	 * @return boolean
	 */
	public function isDefault()
	{
	    return $this->default;
	}

	/**
	 * 
	 * @param boolean $default
	 * @return ProductTranslate
	 */
	public function setDefault(boolean $default)
	{
	    $this->default = $default;
	    return $this;
	}
}