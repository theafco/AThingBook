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
        $q = $this->content_model->createQuery('c');
        $q	->addOrderBy('c.id DESC');
        $this->view->contents = $q->execute();
    }

    public function viewAction()
    {
        $itemId = $this->getRequest()->getParam('item');
        $content = $this->content_model->findOneById($itemId);
        $this->view->content = $content;
    }


}



