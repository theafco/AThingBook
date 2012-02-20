<?php
class My_Controller_Action_Helper_Content extends Zend_Controller_Action_Helper_Abstract
{
    private $_contentModel = null;
    
    public function init(){
        $this->_contentModel = new Model_Content();
    }

    /**
     * Return content model
     * 
     * @return Model_Content
     */
	protected function getModel() {
	    return $this->_contentModel;
	}
	
	/**
	 * Return lastest content in limitation
	 * 
	 * @param integer $limit
	 * @return Doctrine_Collection
	 */
	public function getLastestContent($limit) {
	    return $this->getModel()->findLast($limit);
	}
	
	/**
	 * Return lastest content by category in limitation
	 *
	 * @param integer $limit,integer $category
	 * @return Doctrine_Collection
	 */
	public function getLastestContentByCategory($categoryId,$limit) {
		return $this->getModel()->findLastByCategory($categoryId,$limit);
	}
}
