<?php

class Content_Form_ArticleSearchWithFilter extends Application_Form_Search
{

    public function init()
    {
    	parent::init();

		$this->searchBy->setMultiOptions(array(
			'id'=>'รหัสเนื้อหา',
			'name'=>'หัวเรื่อง',
		));

		$byCategory = new Zend_Form_Element_Select('category',array(
			'label'		=>	'หมวดเนื้อหา',
			'dojoType'	=>	'dijit.form.Select',
			'multiOptions'	=>	array(
									''	=>	'ทุกหมวดเนื้อหา',
								),
		));
		
		$categoryModel = new Model_ArticleCategory();
		$categories = $categoryModel->findAll()->toKeyValueArray('id', 'name');
		$byCategory->addMultiOptions($categories);

		$this->addElements(array($byCategory));
		
		$this->addSubmitButton();
    }

}

