<?php

/**
 * User
 * 
 * @property Doctrine_Record() orders
 * @property string name
 * @property string genderText
 * @property string address
 * @property string phone
 * @property Model_Role role
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Model_User extends Model_BaseUser
{
	public function setUp(){
		parent::setUp();
		
		$this->hasOne('Model_Role as role',array(
			'local'		=>	'role_id',
			'foreign'	=>	'id',
		));
		
		$this->hasMany('Model_PurchaseOrder as orders',array(
				'local'		=>	'user_id',
				'foreign'	=>	'id',
		));
	}
	
	public function setPassword($value)
	{
	    parent::_set('password', md5($value));
	}
	
	public function getName() 
	{
	    return $this->first_name . ' ' . $this->last_name;
	}
	
	public function getAddress() 
	{
	    $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
	    return $view->address(array(
	    	'address1'		=>	$this->address1,
	    	'subdistrict'	=>	$this->subdistrict,
	    	'district'		=>	$this->district,
	    	'provincecode'	=>	$this->province_code,
	    	'zipcode'		=>	$this->zipcode,
	    ));
	}

	public function getGenderText()
	{
		switch ($this->gender) {
			case 'm':
				$strGender = 'ชาย';
				break;
			case 'f':
				$strGender = 'หญิง';
				break;
		}
		return $strGender;
	}
	
	public function getPhone() 
	{
		if (!empty($this->telephone)) {
			$strPhone = ' บ้าน: ' . $this->phoneformat($this->telephone);
		}
		if (!empty($this->mobilephone)) {
			$strPhone .= ' มือถือ: ' . $this->phoneformat($this->mobilephone);
		}
		if (!empty($strPhone)) {
		    return $strPhone;
		}
		return false;
	}
	
	private function phoneFormat($phone)
	{
		$phone = preg_replace("/[^0-9]/", "", $phone);
		 
		if (strlen($phone) == 7) {
			$string = preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
		} elseif (strlen($phone) == 9) {
			$string = preg_replace("/([0-9]{2})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
		} elseif (strlen($phone) == 10) {
			$string = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
		} else {
			$string = $phone;
		}
	
		return $string;
	}

}