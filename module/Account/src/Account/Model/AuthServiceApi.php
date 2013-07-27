<?php
namespace Account\Model;
use Zend\ServiceManager\ServiceManager;
use Zend\Console\Request;
// HTTP_API_KEY
class AuthServiceApi
{
	private $sm;
	private $identity;
	
	public function __construct(ServiceManager $sm)
	{
		$this->sm = $sm;
	}
	
	public function hasIdentity()
	{
		if ($this->sm->get('request') instanceof Request)
			return false;
		
		if ($this->identity != null)
			return $this->identity;
		
		$apiKey = $this->sm->get('request')->getServer('HTTP_API_KEY');
		if (!$apiKey)
			return false;
		
		$em = $this->sm->get('doctrine.entitymanager.orm_default');
		$token = $em->getRepository('Account\Entity\AuthToken')->findOneByToken($apiKey);
		if ($token == null)
			return false;
		$this->identity = $token->getUser();
		return true;
	}
	
	public function getIdentity()
	{
		if ($this->hasIdentity())
			return $this->identity;
		return null;
	}
}