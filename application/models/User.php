<?php

/**
 * User
 * 
 * @property Doctrine_Record() orders
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
		
		$this->hasOne('Role as role',array(
			'local'		=>	'role_id',
			'foreign'	=>	'id',
		));
		
		$this->hasMany('Content as createdContents',array(
				'local'		=>	'id',
				'foreign'	=>	'created_by_id',
		));
		
		$this->hasMany('ProductOrder as orders',array(
				'local'		=>	'user_id',
				'foreign'	=>	'id',
		));
	}
	
	public static function getInstance(){
		static $_table = null;
		if(null==$_table){
			$class = __CLASS__;
			$_table = new $class();
		}
		return $_table;
	}
}