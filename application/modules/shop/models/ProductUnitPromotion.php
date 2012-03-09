<?php

/**
 * ProductUnitPromotion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Model_ProductUnitPromotion extends Model_BaseProductUnitPromotion
{
    const SPECIAL_UNIT_PRICE = 1;
    const SPECIAL_TOTAL_PRICE = 2;
    
	public function setUp()
	{
	    parent::setUp();
	    
	    $this->hasOne('Model_Product as product',array(
	    		'local'		=>	'product_id',
	    		'foreign'	=>	'id',
	    ));
	}
	
	public function createQuery($alias)
	{
		$q = $this->getTable()->createQuery($alias);
		return $q;
	}
	
	public function getName()
	{
		return 'specialPrice';
	}
	
	public function toString()
	{
	    $string = 'ซื้อครบ ' . Zend_Locale_Format::toNumber($this->in_value) . ' เล่ม';
	    
	    $outputType = $this->out_type_id;
	    if ($outputType == self::SPECIAL_UNIT_PRICE) {
	        $string .= ' ราคาหน่วยละ ';
	    } else if($outputType == self::SPECIAL_TOTAL_PRICE) {
	        $string .= ' ราคาเพียง ';
	    }
	    $string .= Zend_Registry::get('Zend_Currency')->toCurrency($this->out_value);
	    
	    return $string;
	}
}