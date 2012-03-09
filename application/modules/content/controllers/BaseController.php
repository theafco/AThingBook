<?php
class Content_BaseController extends Zend_Controller_Action
{
    /**
     * @var Model_Article
     */
    protected $_articleModel = null;
    /**
     * @var Model_ArticleCategory
     */
    protected $_categoryModel = null;
    
    public function init()
    {
        $this->_articleModel = new Model_Article();
        $this->_categoryModel = new Model_ArticleCategory();
    }
}

