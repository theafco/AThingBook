<?php

/**
 * ProductOrderItem
 * 
 * @property Model_ProductOrder order
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Model_ProductOrderItem extends Model_BaseProductOrderItem
{
    public function setUp()
    {
        parent::setUp();

        $this->hasOne('ProductOrder as order',array(
        		'local'		=>	'order_id',
        		'foreign'	=>	'id',
        ));
    }
}