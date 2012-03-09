<?php
class Auth_Controller_Action_Helper_Authen extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * 
	 * @var Zend_Auth
	 */
	private $_auth;
	private $_user;
	private $_acl;

	public function __construct()
	{
		$this->_auth = Zend_Auth::getInstance();
	}
	/**
	 * 
	 * @param string $identity
	 * @param string $credential
	 * @return Zend_Auth_Result
	 */
	public function login ($identity,$credential,$adminMode=false)
	{
		$adapter = new My_Auth_Adapter_Doctrine($identity,$credential,$adminMode);
		$result = $this->_auth->authenticate($adapter);
		if ($result->isValid()) {
		    
		    $authData = $adapter->getResultArray('password');
			$this->_auth->getStorage()->write($authData);

		}
		return $result;
	}
	
	public function logout ()
	{
	    $user = $this->getUser();
	    if (!empty($user)) {
	        $this->_auth->clearIdentity();
	        $this->_auth->getStorage()->clear();
	        //redirect
	        $referer = $this->getRequest()->getServer('HTTP_REFERER');
// 	        if (!empty($referer)) {
	            $this->getResponse()->setRedirect($referer);
// 	        }
	    }
	    
	    $this->getResponse()->setRedirect('/');
	}
    /**
     * Return current authorized user
     * @return Model_User return false when fail
     */
    public function getUser()
    {
        if (empty($this->_user)) {
            if ($this->_auth->hasIdentity()) {
            	$this->_user = new Model_User();
            	$this->_user->fromArray($this->_auth->getStorage()->read());
            } else {
            	return false;
            }
        }
        
       	return $this->_user;
 
    }
    /**
     * Protect admin zone
     * @throws Zend_Auth_Exception
     * @return void
     */
    public function protect()
    {
        $user = $this->getUser();
        if (!empty($user)) {
        	if ($this->_user->role->is_admin) {return;}
        }
      	throw new Zend_Auth_Exception('No Permission');
    }
    /**
     * Return access control list
     * @return Zend_Acl
     */
    public function getAcl()
    {
        if (empty($this->_acl)) {
        	$this->_acl =  Zend_Registry::get('Zend_Acl');  
        }
        return $this->_acl;
    }
}
