<?php
class Shop_BaseController extends Zend_Controller_Action
{
    
    /**
     * @var Model_Product
     */
    protected $_productModel = null;
    /**
     * @var Model_PurchaseOrder
     */
    protected $_purchaseOrderModel = null;
    /**
     * @var Model_PurchaseOrderItem
     */
    protected $_purchaseOrderItemModel = null;
    /**
     * 
     * @var Model_ProductUnitPromotion
     */
    protected $_productUnitPromotion = null;
    
    public function init()
    {
        $this->_productModel = new Model_Product();
        $this->_purchaseOrderModel = new Model_PurchaseOrder();
        $this->_purchaseOrderItemModel = new Model_PurchaseOrderItem();
        $this->_productUnitPromotion = new Model_ProductUnitPromotion();
    }

}

