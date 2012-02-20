<?php

class My_Auth_Adapter_Doctrine implements Zend_Auth_Adapter_Interface
{

	private $_identity;
	private $_credential;
	private $_resultArray;
	
	public function __construct($identity, $credential)
	{
		$this->_identity	=	$identity;
		$this->_credential	= 	$credential;
	}
	
    public function authenticate ()
    {
    	$q = Model_User::getInstance()->getTable()->createQuery('u');
    	$q->where('u.email = ? AND u.password = ?', array($this->_identity, md5($this->_credential)));
    	$result = $q->execute(array(),Doctrine_Core::HYDRATE_RECORD);
    	
    	if ($result->count() == 1) {
    		$this->_resultArray = $result->getFirst()->toArray();
    		return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->_identity);
    	} else {
    		return new Zend_Auth_Result(Zend_Auth_Result::FAILURE, $this->_identity,array('อีเมล์หรือรหัสผ่านไม่ถูกต้อง'));
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
