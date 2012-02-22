<?php

class Default_ProductController extends Zend_Controller_Action
{
    private $_productModel = null;
    
    public function init()
    {
        //dojo dialog theme
        $this->view->getHelper('headLink')->appendStylesheet('/js/libs/dojo/1.7.1/dojox/widget/Dialog/Dialog.css');
        
        $this->_productModel = new Model_Product();
        $this->view->headLink()->appendStylesheet('/css/default_product.css');
    }

    public function indexAction()
    {
        $catId = $this->getRequest()->getParam('cat');
        //$category = $this->_helper->product->getProductCategory($catId);
        
//         if (!empty($category)) {
            
            
	        $products = $this->_helper->product->getLastestProductByCategory($catId);
	        
	        //Block the page, if no product.
	        if (!$products->count()) {
	            throw new Zend_Controller_Action_Exception('There is no product',404);
	        }

	        $this->_helper->layout()->headline = $products->getFirst()->category->name;
	        $this->view->products = $products;
	        
//         }
    }

    public function viewAction()
    {
        $itemId = $this->getRequest()->getParam('item');
        if(is_numeric($itemId)) {
            $product = $this->_productModel->findOneById($itemId);
            if(!empty($product)) {
                $this->_helper->layout()->headline = $product->name;
                $this->view->product = $product;
            } else {
                throw new Zend_Controller_Action_Exception('Invalid Product',404);
            }
        } else {
        	throw new Zend_Controller_Action_Exception('Invalid ItemID',404);
        }

    }

}



