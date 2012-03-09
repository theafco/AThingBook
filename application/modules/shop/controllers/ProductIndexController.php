<?php
require_once('BaseController.php');
class Shop_ProductIndexController extends Shop_BaseController
{

    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        $request = $this->getRequest();
    	$catgoryId = $this->getRequest()->getParam('category');
    	
    	//get product by category
    	$products = $this->_productModel->findLastByCategory($catgoryId);
    	
	    //Block the page, if no product.
	    if (!$products->count()) {
	    	throw new Zend_Controller_Action_Exception('Invalid Product Category');
	  	}

	  	$this->_helper->layout()->headline = $products->getFirst()->category->name;
	  	$this->view->products = $products;
    }

    public function viewAction()
    {
        $request = $this->getRequest();
    	$id = $request->getParam('id');
    	
        if(!empty($id)) {
            $product = $this->_productModel->findOneBy('rowid',$id);
            if(!empty($product)) {
                $this->_helper->layout()->headline = $product->name;
                $this->view->product = $product;
            } else {
                throw new Zend_Controller_Action_Exception('Invalid Product');
            }
        } else {
        	throw new Zend_Controller_Action_Exception('Invalid ID');
        }
    }


}



