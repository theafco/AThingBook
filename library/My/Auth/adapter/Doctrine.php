<?php

class My_Auth_Adapter_Doctrine implements Zend_Auth_Adapter_Interface
{

	private $_identity;
	private $_credential;
	private $_adminMode;
	private $_resultArray;
	
	public function __construct($identity,$credential,$adminMode=false)
	{
	    $this->_adminMode	=	$adminMode;
		$this->_identity	=	$identity;
		$this->_credential	= 	$credential;
	}
	
    public function authenticate()
    {
        $userModel = new Model_User();
    	$q = $userModel->createQuery('u');
    	$q->where('u.email = ? AND u.password = ?', array($this->_identity, md5($this->_credential)));
    	$result = $q->execute();
    	
    	if ($result->count() == 1) {
    	    $user = $result->getFirst();
    	    if ($this->_adminMode) {
    	        if (!$user->role->is_admin) {
    	            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE,null,array('ไม่มีสิทธิ์ผู้ดูแล'));
    	        }
    	    }
    		$this->_resultArray = $user->toArray();
    		return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS,$this->_identity);
    	} else {
    		return new Zend_Auth_Result(Zend_Auth_Result::FAILURE,null,array('รหัสไม่ถูกต้อง'));
    	}
    }
    
    public function getResultArray ($excludeFields = null)
    {
    	if (null == $this->_resultArray) {
    		return false;
    	}
    	
    	if (null != $excludeFields) {
    		$excludeFields = (array) $excludeFields;
    		foreach ($this->_resultArray as $key=>$value) {
    			if (!in_array($key, $excludeFields)) {
    				$resultArray[$key] = $value;
    			}
    		}
    		return $resultArray;
    	}
    	return $this->_resultArray;
    }
}
