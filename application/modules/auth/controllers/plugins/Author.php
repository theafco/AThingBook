<?php
class Controller_Plugin_Author extends Zend_Controller_Plugin_Abstract
{

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {

     	    $acl = new Zend_Acl();

			//roles
     	    $acl->addRole(new Zend_Acl_Role(Model_Role::USER_MEMBER));
     	    $acl->addRole(new Zend_Acl_Role(Model_Role::USER_ADMIN),Model_Role::USER_MEMBER);
     	    
        	//resources
     	    $acl->addResource(new Zend_Acl_Resource('cart'));
     	    
     	    //permissions
     	    $acl->allow(Model_Role::USER_MEMBER,'cart');
     	    
     	    Zend_Registry::set('Zend_Acl', $acl);

    }
    
}
?>