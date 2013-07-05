<?php
namespace Account\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Account\Model\AuthTokenRepository")
 * @ORM\Table(name="AuthTokens")
 */
class AuthToken
{
	/**
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Account\Entity\User", inversedBy="authTokens")
	 */
	private $user;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date;

	/**
	 * @ORM\Column(type="string")
	 */
	private $token;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $valid;

	
	public function getId() {
	    return $this->id;
	}
	
	/**
	 *
	 * @return AuthToken
	 */
	public function setId($id) {
	    $this->id = $id;
	
	    return $this;
	}

	/**
	 * @return User
	 */
	public function getUser() {
	    return $this->user;
	}
	
	/**
	 * @param User
	 * @return AuthToken
	 */
	public function setUser(User $user) {
	    $this->user = $user;
	    return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate() {
	    return $this->date;
	}
	
	/**
	 * @param \DateTime
	 * @return AuthToken
	 */
	public function setDate(\DateTime $date) {
	    $this->date = $date;
	    return $this;
	}

	
	public function getToken() {
	    return $this->token;
	}
	
	/**
	 * 
	 * @return AuthToken
	 */
	public function setToken($token) {
	    $this->token = $token;
	
	    return $this;
	}

	
	public function isValid() {
	    return $this->valid;
	}
	
	/**
	 *
	 * @return AuthToken
	 */
	public function setValid($valid) {
	    $this->valid = $valid ? true : false;
	
	    return $this;
	}
}