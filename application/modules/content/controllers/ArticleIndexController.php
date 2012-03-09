<?php
require_once('BaseController.php');
class Content_ArticleIndexController extends Content_BaseController
{

    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $categoryId = $request->getParam('category');

        $articles = $this->_articleModel->findLastByCategory($categoryId);
        
        //Block the page, if no article.
        if (!$articles->count()) {
        	throw new Zend_Controller_Action_Exception('Invalid Article');
        }
        
        $this->_helper->layout()->headline = $articles->getFirst()->category->name;
        $this->view->articles = $articles;
    }

    public function viewAction()
    {
        $id = $this->getRequest()->getParam('id');
        if (empty($id)) { throw new Zend_Controller_Action_Exception('Invalid ID'); }
        
        $article = $this->_articleModel->findOneBy('rowid',$id);
        if (empty($article)) { throw new Zend_Controller_Action_Exception('Invalid Article'); }
        
        $this->_helper->layout()->headline = $article->name;
        $this->view->article = $article;
    }


}



