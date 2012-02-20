<?php

class Application_Form_ProductSearchWithFilter extends Application_Form_Search
{

    public function init()
    {
    	parent::init();
    	$this->setName('product_search');
    	$this->setMethod('get');

    	$this->setDecorators(array(
			array('ViewScript',array('viewScript'=>'forms/product_search_with_filter.phtml')),
		));

		$searchby = $this->getElement('by')->setMultiOptions(array(
			'id'=>'รหัสสินค้า',
			'name'=>'ชื่อสินค้า',
		));

		$byCategory = new Zend_Form_Element_Select('category',array(
			'label'		=>	'หมวดสินค้า',
			'dojoType'	=>	'dijit.form.Select',
			'multioptions'	=>	array(
									''	=>	'ทุกหมวดสินค้า',
								),
			'order'		=>	2,
			'Filters'	=>	$this->_elementFilters,
			'Decorators'=>	$this->_elementDecorators,
		));
		
		$categories = Model_ProductCategory::getInstance()->getTable()->findAll()->toKeyValueArray('id', 'name');
		$byCategory->addMultiOptions($categories);

		$this->addElements(array(
			$byCategory,
		));
		
    }

}

