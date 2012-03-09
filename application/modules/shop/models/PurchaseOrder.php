<?php

/**
 * PurchaseOrder
 * 
 * @property Doctrine_Collection items
 * @property Model_User user
 * @property Model_PurchaseOrderStatus status
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Model_PurchaseOrder extends Model_BasePurchaseOrder
{
	public function setUp()
	{
	    parent::setUp();

	    $this->hasMany('Model_PurchaseOrderItem as items',array(
	    		'local'		=>	'id',
	    		'foreign'	=>	'order_id',
	    ));
	    
	    $this->hasOne('Model_User as user',array(
	    		'local'		=>	'user_id',
	    		'foreign'	=>	'id',
	    ));
	    
	    $this->hasOne('Model_PurchaseOrderStatus as status',array(
	    		'local'		=>	'status_id',
	    		'foreign'	=>	'id',
	    ));
	}
	
	public function getShippingAddress()
	{
	    $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
	    return $view->address(array(
	    	'address1'		=>	$this->shipping_address1,
	    	'subdistrict'	=>	$this->shipping_subdistrict,
	    	'district'		=>	$this->shipping_district,
	    	'provincecode'	=>	$this->shipping_province_code,
	    	'zipcode'		=>	$this->shipping_zipcode,
	    ));
	}
}