<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        //Enable Dojo View Helper
		Zend_Dojo::enableView($this->view);
    }

    public function indexAction()
    {
    	//Zend_Debug::dump(Zend_Registry::get('Zend_Acl')->hasRole(new My_Acl_Role_Admin()));
    	
    	//Auth session namespace is set, then logged in
    	//if ($this->getHelper('authenticate')->hasIdentity()) {
    	if (Zend_Auth::getInstance()->hasIdentity()) {
    		//$identity = Zend_Auth::getInstance()->getStorage()->read();
    		//Zend_Debug::dump($identity);
			$this->render('dashboard');
		}
		
    	$formLogin = new Application_Form_Login();
    	$formLogin->setAction('/admin/index/login');
		$this->view->formLogin = $formLogin;
		
    }

    public function loginAction()
    {
    	if ($this->getRequest()->isPost()) {
    		$input = $this->getRequest()->getParams();
    		$this->getHelper('authenticate')->login($input['email'], $input['password']);
    	}
    	
		$this->_helper->redirector('index');
    }

    public function logoutAction()
    {
    	$this->getHelper('authenticate')->logout();
    	$this->_helper->redirector('index');
    }

}





