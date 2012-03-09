<?php

/**
 * Product
 * 
 * @property Model_ProductCategory category
 * @property string categoryName
 * @property string productCode
 * @property Doctrine_Collection promotions
 *  
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Model_Product extends Model_BaseProduct
{
	public function setUp(){
		parent::setUp();
		
		$this->hasOne('Model_ProductCategory as category',array(
			'local'		=>	'category_id',
			'foreign'	=>	'id',
		));
		
		$this->hasMany('Model_ProductUnitPromotion as promotions',array(
				'local'		=>	'id',
				'foreign'	=>	'product_id',
		));
	}
	/**
	 * 
	 * Return lastest product by category in limitation
	 * 
	 * @param int $categoryId
	 * @param int $limit
	 * @param int $hydrationMode
	 * 
	 * @return mixed
	 */
	public function findLastByCategory($categoryId,$limit=null){
		$q = $this->createQuery('p');
	    $q	->addWhere('p.category_id = ?', $categoryId)
	    	->addOrderBy('p.id DESC');
	    if(!empty($limit)) {
	        $q	->limit($limit);
	    }
	    	
		return $q->execute();
	}
	/**
	 *
	 * @param string $value
	 *
	 * @return Model_Product
	 */
	public function findOneByCode($code){
		$array = explode('-',$code);
		$id = $array[count($array)-1];
		if ($array) {
		    return $this->findOneById($id);
		}
		return false;
	}
	/**
	 * Return product code
	 * @return string
	 */
	public function getProductCode()
	{
		return strtoupper($this->category->code) . $this->id;
	}
	/**
	 * Return current product price
	 * @return integer
	 */
	public function getPrice()
	{
	    if (!empty($this->sale_price)) {
	        return $this->sale_price;
	    }
	    return $this->normal_price;
	}
	/**
	 * Return category name
	 * @return string
	 */
	public function getCategoryName()
	{
	    return $this->category->name;
	}
	/**
	 * Return release status text
	 * @return string
	 */
	public function getRelease()
	{
	    return ( $this->is_released?'เปิดการขาย':'ปิดการขาย' );
	}
}