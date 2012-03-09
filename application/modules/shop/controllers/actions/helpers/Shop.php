<?php
class Shop_Controller_Action_Helper_Shop extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @var Model_Product
     */
    private $_productModel = null;
    /**
     *
     * @var Model_ProductCategory
     */
	private $_categoryModel = null;
	/**
	 * 
	 * @var Zend_Session_Namespace
	 */
    private $_cartSession = null;
    
    public function init(){
        $this->_productModel = new Model_Product();
		$this->_categoryModel = new Model_ProductCategory();
		$this->_cartSession = Zend_Registry::get('Shop_Cart_Session');
    }
	/**
	 *
	 * @param integer $limit,integer $categoryId
	 * @return Doctrine_Collection
	 */
	public function getLastProductByCategory($categoryId,$limit=null) {
		return $this->_productModel->findLastByCategory($categoryId,$limit);
	}
	/**
	 * Return current cart items
	 * @return array return false if fail
	 */
	public function getCartItems()
	{  
		if(count($this->_cartSession->items)) {
			$items = array();
			foreach ($this->_cartSession->items as $id=>$params) {
				$product = $this->_productModel->findOneBy('rowid',$id);
				$items[$id] = array('product'=>$product,'params'=>$params);
			}
			return $items;
		}  

	    return false;
	}
	/**
	 * Return the number of cart items
	 * @return integer
	 */
	public function getCartItemCount()
	{
	    return count($this->_cartSession->items);
	}

}
