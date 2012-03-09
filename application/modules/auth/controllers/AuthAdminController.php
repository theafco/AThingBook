<?php
require_once('BaseController.php');
class Auth_AuthAdminController extends Auth_BaseController
{

    public function init()
    {
        parent::init();
        
        $this->_helper->ajaxContext
	        ->addActionContext('login', 'json')
	        ->initContext();
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
    	$request = $this->getRequest();
        if ($request->isPost()) {
	        $input = $request->getPost();
	        $identity = $input['identity'];
	        $credential = $input['password'];
	     
	        $result = $this->_helper->authen->login($identity,$credential,true);
	        if ($result->isValid()) {
	            $this->view->code = 0;
	        } else {
	            $this->view->code = -1;
	            $resultMsg = $result->getMessages();
	            $this->view->message = $resultMsg[0];
	        }
        } else {
            throw new Zend_Controller_Action_Exception('Require Post');
        }
    }

    public function logoutAction()
    {
         $this->_helper->authen->logout();
         //clear all session
         Zend_Session::destroy();
    }


}





