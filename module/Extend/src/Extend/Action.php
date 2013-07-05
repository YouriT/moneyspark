<?php
namespace Extend;

use Zend\Mvc\Controller\AbstractActionController;

class Action extends AbstractActionController
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
	
	public function getIdentity()
	{
		if (!$this->identity)
			$this->identity = $this->getServiceLocator()->get('AuthStorage')->read();
		return $this->identity;
	}
}