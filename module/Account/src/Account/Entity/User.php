<?php
namespace Account\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Account\Model\UserRepository")
 * @ORM\Table(name="Users")
 */
class User
{	
	/**
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $locked = false;
	
	/**
	 * @ORM\Column(type="string")
	 */
	private $role = 'user';

	/**
	 * @ORM\Column(type="string")
	 */
	private $fullName;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $phone;

	/**
	 * @ORM\Column(type="string")
	 */
	private $email;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $password;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $registerDate;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $lastLogin;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $paymillId;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $verified = false;
	
	/**
	 * @ORM\Column(type="string")
	 */
	private $validationCode;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	private $phoneVerified = false;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $companyName;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $companyAddress;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $companyZip;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $companyCity;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $companyCountry;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $companyVat;
	
	/**
	 * @ORM\OneToMany(targetEntity="Payment\Entity\Bill", mappedBy="user")
	 */
	private $bills;
	
}