<?php
namespace Extend;

use Account\Entity\User;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

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
	
	private $jsonModel;
	
	/**
	 * @return JsonModel
	 */
	protected function getJsonModel($array = array())
	{
		if (!$this->jsonModel)
		{
			$this->setCrossDomainOptions(); // Only dev mode
			$this->jsonModel = new JsonModel($array);
			if ($this->params()->fromQuery('callback') != null)
				$this->jsonModel->setJsonpCallback($this->params()->fromQuery('callback'));
		}
		return $this->jsonModel;
	}
	
	protected function setCrossDomainOptions()
	{
		$this->getResponse()->getHeaders()
			->addHeaderLine('Access-Control-Allow-Origin', 'http://moneyspark.app')
			->addHeaderLine('Access-Control-Allow-Methods', 'GET, HEAD, POST, PUT, DELETE, OPTIONS')
			->addHeaderLine('Access-Control-Allow-Headers', 'api-key, origin, x-mime-type, x-requested-with, x-file-name, content-type')
			->addHeaderLine('Access-Control-Max-Age', '1728000')
			->addHeaderLine('Access-Control-Allow-Credentials', true);
	}
	
	public function options()
	{
		$this->setCrossDomainOptions();
		return false;
	}

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