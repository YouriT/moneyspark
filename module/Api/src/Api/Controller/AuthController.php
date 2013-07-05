<?php
namespace Api\Controller;

use Zend\View\Model\JsonModel;
use Extend\RestAction;
use Account\Form\Login;
use Zend\Form\Annotation\AnnotationBuilder;
use Account\Entity\AuthToken;
use Account\Model\Utilities;

class AuthController extends RestAction
{
	protected $formAuth;
	protected $storage;
	/**
	 * @var Zend\Authentication\AuthenticationService
	 */
	protected $authService;
	
	public function getAuthService()
	{
		if (!$this->authService)
			$this->authService = $this->getServiceLocator()->get('AuthService');
	
		return $this->authService;
	}
	
	public function getFormAuth()
	{
		if (!$this->formAuth)
		{
			$login = new Login();
			$builder = new AnnotationBuilder();
			$this->formAuth = $builder->createForm($login);
		}
	
		return $this->formAuth;
	}
	
	public function create($data)
	{
		$form = $this->getFormAuth();
		$form->setData($data);
		$ret = array();
		if ($form->isValid())
		{
			$this->getAuthService()->getAdapter()
			->setIdentityValue($form->get('email')->getValue())
			->setCredentialValue($form->get('password')->getValue());

			$result = $this->getAuthService()->authenticate();
			if ($result->isValid())
			{
				$tokenRing = '';
				while (true) {
					$tokenRing = Utilities::genToken(70);
					$exists = $this->getEntityManager()->getRepository('Account\Entity\AuthToken')->findBy(array(
						'token' => $tokenRing,
						'valid' => true
					));
					if ($exists == null)
						break;
				}
				
				foreach ($result->getIdentity()->getAuthTokens() as $t)
				{
					$t->setValid(false);
				}
				
				$token = new AuthToken();
				$this->getEntityManager()->persist($token);
				$token->setDate(new \DateTime())
					->setUser($result->getIdentity())
					->setValid(true)
					->setToken($tokenRing);
				
				$this->getEntityManager()->flush();
				
				$ret['token'] = $token->getToken();
			}
			else
				$ret['error'] = array('code'=>'403','message'=>'Wrong identity');
		}
		else
			$ret['error'] = array('code'=>'403','message'=>'Wrong identity');
		
		return new JsonModel($ret);
	}
	
	public function getList()
	{
		return new JsonModel();
	}
	
	public function get($id)
	{
		return new JsonModel();
	}
	
	public function update($id, $data)
	{
		return new JsonModel();
	}
	
	public function delete($id)
	{
		return new JsonModel();
	}
}
