<?php
namespace Account\Model;

use Zend\Mvc\MvcEvent;

use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Account\Entity\User;
     
class AuthAcl extends AbstractPlugin
{
    protected $role;
    /**
     * @var MvcEvent
     */
    private $mvcEvent;
 
    private function getRole()
    {
        if (!$this->role) {
        	if ($this->getController()->getServiceLocator()->get('AuthServiceApi')->hasIdentity())
        		$this->role = $this->getController()->getServiceLocator()->get('AuthServiceApi')->getIdentity()->getRole();
        	else
        		$this->role = User::USER_ROLE_GUEST;
        }
        return $this->role;
    }
     
    public function doAuthorization(MvcEvent $e)
    {
    	$this->mvcEvent = $e;
        $acl = new Acl();
        
        $acl->addRole(new Role(User::USER_ROLE_GUEST));
        $acl->addRole(new Role(User::USER_ROLE_BANNED), User::USER_ROLE_GUEST);
        $acl->addRole(new Role(User::USER_ROLE_NORMAL), User::USER_ROLE_GUEST);
        $acl->addRole(new Role(User::USER_ROLE_ADMIN), User::USER_ROLE_NORMAL);
         
        $acl->addResource(new Resource('account'));
        $acl->addResource(new Resource('front'));
        $acl->addResource(new Resource('api_error'));
        $acl->addResource(new Resource('api_auth'));
        $acl->addResource(new Resource('api_register'));
        $acl->addResource(new Resource('api_index'));
        $acl->addResource(new Resource('api_cyril'));
        $acl->addResource(new Resource('api_investment'));
        $acl->addResource(new Resource('api_lockbox'));
        $acl->addResource(new Resource('api_product'));
        $acl->addResource(new Resource('api_profile'));
        
        $acl->allow(User::USER_ROLE_GUEST, 'api_error', null);
        $acl->allow(User::USER_ROLE_GUEST, 'api_auth', null);
        $acl->allow(User::USER_ROLE_GUEST, 'api_register', null);
        $acl->allow(User::USER_ROLE_GUEST, 'api_cyril', null);
        $acl->allow(User::USER_ROLE_GUEST, 'api_investment', null);
        $acl->allow(User::USER_ROLE_GUEST, 'api_lockbox', null);
        $acl->allow(User::USER_ROLE_GUEST, 'api_product', null);
        $acl->allow(User::USER_ROLE_GUEST, 'api_profile', null);
        
//         $acl->allow('anonymous', 'Login', 'view');
         
//         $acl->allow('user',
//             array('Application'),
//             array('view')
//         );
         
        //admin is child of user, can publish, edit, and view too !
//         $acl->allow('admin',
//             array('Application'),
//             array('publish', 'edit')
//         );
         
        $resource = $e->getRouteMatch();
        $resource = strtolower($resource->getParam('__NAMESPACE__').'_'.$resource->getParam('__CONTROLLER__'));
        $action = strtolower($e->getRouteMatch()->getParam('action'));
//         var_dump($e->getRequest()->getMethod());exit;
        if (!$acl->isAllowed($this->getRole(), $resource, $action))
        {
            $router = $e->getRouter();
            $url    = $router->assemble(array(), array('name' => 'api/error'));
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            $response->sendHeaders();
            $e->stopPropagation();            
        }
    }
}