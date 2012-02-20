<?php
class My_Controller_Action_Helper_Product extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * 
     * @var Model_Product
     */
    private $_productModel = null;
    /**
     *
     * @var Model_ProductCategory
     */
	private $_categoryModel = null;
    
    public function init(){
        $this->_productModel = new Model_Product();
		$this->_categoryModel = new Model_ProductCategory();
    }

    /**
     * @return Model_Product
     */
	protected function getProductModel() {
	    return $this->_productModel;
	}
	
	/**
	 * @return Model_ProductCategory
	 */
// 	protected function getCategoryModel() {
// 		return $this->_categoryModel;
// 	}
	
	/**
	 * 
	 * @param integer $limit
	 * @return Doctrine_Collection
	 */
	public function getLastestProduct($limit) {
	    return $this->getProductModel()->findLast($limit);
	}
	
	/**
	 *
	 * @param integer $limit,integer $category
	 * @return Doctrine_Collection
	 */
	public function getLastestProductByCategory($categoryId,$limit=null) {
		return $this->getProductModel()->findLastByCategory($categoryId,$limit);
	}
	
	/**
	 * Return product code
	 * 
	 * @param integer $id
	 * 
	 * @return string
	 */
	public function getProductCode($id)
	{
	    $product = $this->_productModel->findOneById($id);
	    if ($product) {
	        return $product->category->id . '-' . $id;
	    } else {
	        return false;
	    }
	}
	/**
	 * 
	 * @param Zend_Session_Namespace $session
	 * 
	 * @return array return false if fail
	 */
	public function getCartItems($session)
	{  
	    if (!empty($session->items)) {
	        if(count($session->items)) {
		        $items = array();
			    foreach ($session->items as $productCode=>$params) {
			    	$product = $this->_productModel->findOneByCode($productCode);
			    	$items[$productCode] = array('product'=>$product,'params'=>$params);
			    }
			    return $items;
	        }  
	    }
	    
	    return false;
	}
}
