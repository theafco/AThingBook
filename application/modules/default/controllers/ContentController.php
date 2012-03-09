<?php

class Default_ContentController extends Zend_Controller_Action
{
    private $content_model;
    
    public function init()
    {
        $this->content_model = new Model_Content();
        $this->_helper->layout()->headline = 'บทความ';
    }

    public function indexAction()
    {
//         $catId = $this->getRequest()->getParam('cat');
//         $contents = $this->_helper->content->getLastestContentByCategory($catId);
        
//         //Block the page, if no product.
//         if (!$contents->count()) {
//         	throw new Zend_Controller_Action_Exception('Invalid Content',404);
//         }
        
//         $this->_helper->layout()->headline = $contents->getFirst()->category->name;
//         $this->view->contents = $contents;
    }

    public function viewAction()
    {
//         $itemId = $this->getRequest()->getParam('item');
//         $content = $this->content_model->findOneById($itemId);
//         $this->view->content = $content;
    }


}



