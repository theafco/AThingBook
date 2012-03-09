<?php

class Shop_Form_ProductSearchWithFilter extends Application_Form_Search
{

    public function init()
    {
    	parent::init();

		$this->searchBy->setMultiOptions(array(
			'id'=>'รหัสสินค้า',
			'name'=>'ชื่อสินค้า',
		));

		$byCategory = new Zend_Form_Element_Select('category',array(
			'label'		=>	'หมวดสินค้า',
			'dojoType'	=>	'dijit.form.Select',
			'multioptions'	=>	array(
									''	=>	'ทุกหมวดสินค้า',
								),
		));
		
		$categoryModel = new Model_ProductCategory();
		$categories = $categoryModel->findAll()->toKeyValueArray('id', 'name');
		$byCategory->addMultiOptions($categories);

		$this->addElements(array($byCategory));
		
		$this->addSubmitButton();
    }

}

