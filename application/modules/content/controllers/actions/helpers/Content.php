<?php
class Content_Controller_Action_Helper_Content extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * 
     * @var Model_Article
     */
    private $_articleModel = null;
    /**
     * 
     * @var Model_ArticleCategory
     */
    private $_categoryModel = null;
    
    public function init(){
        $this->_articleModel = new Model_Article();
        $this->_categoryModel = new Model_ArticleCategory();
    }
	/**
	 * Return lastest article by category in limitation
	 *
	 * @param integer $limit,integer $category
	 * @return Doctrine_Collection
	 */
	public function getLastArticleByCategory($categoryId,$limit=null) {
		return $this->_articleModel->findLastByCategory($categoryId,$limit);
	}
// 	/**
// 	 * Return all categories
// 	 * @return Doctrine_Collection
// 	 */
// 	public function getAllCategory()
// 	{
// 	    return $this->_categoryModel->findAll();
// 	}
}
