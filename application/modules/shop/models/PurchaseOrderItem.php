<?php

/**
 * PurchaseOrderItem
 * 
 * @property Model_PurchaseOrder order
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Model_PurchaseOrderItem extends Model_BasePurchaseOrderItem
{
    public function setUp()
    {
        parent::setUp();

        $this->hasOne('Model_PurchaseOrder as order',array(
        		'local'		=>	'order_id',
        		'foreign'	=>	'id',
        ));
    }
}