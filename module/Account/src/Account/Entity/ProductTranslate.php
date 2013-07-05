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
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Account\Entity\Product", inversedBy="translations")
	 */
	private $product;
	
	/**
	 * @ORM\Column(type="string")
	 */
	private $title;
	
	/**
	 * @ORM\Column(type="text")
	 */
	private $description;
	
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="string")
	 */
	private $locale;
	
	
	/**
	 * @ORM\Column(type="boolean")
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
	 * @return ProductTranslate
	 */
	public function setDescription($description)
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
	public function setLocale($locale)
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
	public function setDefault($default)
	{
	    $this->default = $default ? true : false;
	    return $this;
	}
	
	public function toArray(){
		return get_object_vars($this);
	}
	
}