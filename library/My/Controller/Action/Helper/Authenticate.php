<?php
class My_Controller_Action_Helper_Authenticate extends Zend_Controller_Action_Helper_Abstract
{
	private $_acl;
	private $_view;
	Private $_authData;
	//private $_ns;
	private $_user;
	
	public function preDispatch(){
// 		$auth = Zend_Auth::getInstance();
		
// 		if (null === $this->_acl) {
// 			$this->_acl = new Zend_Acl();
// 			Zend_Registry::set('Zend_Acl', $this->_acl);
// 		}
		
// 		if ($auth->hasIdentity())
// 		{	
// 			$this->_authData = $auth->getStorage()->read();
// 			$this->_acl->addRole(new Zend_Acl_Role($this->_authData['role_id']));
// 			//$this->_ns = new Zend_Session_Namespace('my.auth',true);
// 			$this->getView()->authenticate = $this->_authData;
// 		}
		$model = new Model_User();
		$this->_user = $model->findOneById(2);
	    //$this->getView()->user = $model->findOneById(2);
	}
	
	public function getUser(){
	    return $this->_user;
	}
	
	public function getView(){
		if(null !== $this->_view)
		{
			return $this->_view;
		}
		$controller = $this->getActionController();
		$this->_view = $controller->view;
		return $this->_view;
	}

	public function login ($identity, $credential)
	{
		$adapter = new My_Auth_Adapter_Doctrine($identity, $credential);
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($adapter);
		if($result->isValid())
		{
			$this->_authData = $adapter->getResultArray('password');
			$auth->getStorage()->write($this->_authData);
		}
	}
	
	public function logout ()
	{
		//Zend_Session::namespaceUnset('my.auth');
		Zend_Auth::getInstance()->clearIdentity();
		Zend_Auth::getInstance()->getStorage()->clear();
	}
}
