<?php
namespace Api\Controller;

use Zend\View\Model\JsonModel;
use Extend\RestAction;
use Account\Form\Register;
use Zend\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Validator\ObjectExists;
use Account\Entity\User;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Account\Model\Utilities;

class RegisterController extends RestAction
{
	protected $formRegister;
	
	public function getFormRegister()
	{
		if (!$this->formRegister)
		{
			$login = new Register();
			$builder = new AnnotationBuilder();
			$this->formRegister = $builder->createForm($login);
		}
	
		return $this->formRegister;
	}
	
	public function create($data)
	{
		$form = $this->getFormRegister();
		
		$form->setData($data);
		if ($form->isValid())
		{
			$repoUser = $this->getEntityManager()->getRepository('Account\Entity\User');
			$validator = new ObjectExists(array('object_repository' => $repoUser, 'fields' => array('email')));
	
			if (!$validator->isValid($form->get('email')->getValue()))
			{
				$clientNumber;
				while (true)
				{
					$clientNumber = Utilities::genToken(7, true);
					$res = $this->getEntityManager()->getRepository('Account\Entity\User')->findByClientNumber($clientNumber);
					if ($res == null)
						break;
				}
				$user = new User();
				$user->setRegisterDate(new \DateTime())
					->setClientNumber($clientNumber)
					->setValidationCode(Utilities::genToken(50));
				$hydrator = new DoctrineObject($this->getEntityManager(), 'Account\Entity\User');
				$hydrator->hydrate($form->getData(), $user);
				$user->setPassword(sha1($user->getPassword()));
				$this->getEntityManager()->persist($user);
				$this->getEntityManager()->flush();
	
				$ret['success'] = array('message'=>"You've been successfully registered");
			}
			else
				$ret['error'] = array('code'=>'1001','message'=>'This account already exists');
		}
		else
			$ret['error'] = array('code'=>'1000','message'=>$form->getMessages());
		
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
