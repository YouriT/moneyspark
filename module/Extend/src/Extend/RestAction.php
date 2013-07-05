<?php
namespace Extend;

use Zend\Mvc\Controller\AbstractRestfulController;

abstract class RestAction extends AbstractRestfulController
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	/**
	 * @var Frontend\Entity\User
	 */
	protected $identity;

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