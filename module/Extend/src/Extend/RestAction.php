<?php
namespace Extend;

use Account\Entity\User;

use Zend\Mvc\Controller\AbstractRestfulController;

abstract class RestAction extends AbstractRestfulController
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	/**
	 * @var \Account\Entity\User
	 */
	protected $identity;

	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
	}
	/**
	 * @return User
	 */
	public function getIdentity()
	{
		if (!$this->identity)
			$this->identity = $this->getServiceLocator()->get('AuthServiceApi')->getIdentity();
		return $this->identity;
	}
	
	public function hasIdentity()
	{
		return $this->getServiceLocator()->get('AuthServiceApi')->hasIdentity();
	}
}