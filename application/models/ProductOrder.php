<?php

/**
 * ProductOrder
 * 
 * @property Doctrine_Collection items
 * @property Model_User user
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Model_ProductOrder extends Model_BaseProductOrder
{
	public function setUp()
	{
	    parent::setUp();

	    $this->hasMany('ProductOrderItem as items',array(
	    		'local'		=>	'id',
	    		'foreign'	=>	'order_id',
	    ));
	    
	    $this->hasOne('User as user',array(
	    		'local'		=>	'user_id',
	    		'foreign'	=>	'id',
	    ));
	}
}