<?php

class Application_Form_ContentSearchWithFilter extends Application_Form_Search
{

    public function init()
    {
    	parent::init();
    	
    	$this->setName('content_search');
    	$this->setMethod('get');

    	$this->setDecorators(array(
			array('ViewScript',array('viewScript'=>'forms/content_search_with_filter.phtml')),
		));

		$searchby = $this->getElement('by')->setMultiOptions(array(
			'id'=>'รหัสเนื้อหา',
			'name'=>'หัวข้อ',
		));

		$byCategory = new Zend_Form_Element_Select('category',array(
			'label'		=>	'หมวดเนื้อหา',
			'dojoType'	=>	'dijit.form.Select',
			'multioptions'	=>	array(
									''	=>	'ทุกหมวดเนื้อหา',
								),
			'order'		=>	2,
			'Filters'	=>	$this->_elementFilters,
			'Decorators'=>	$this->_elementDecorators,
		));
		
		$categories = Model_ContentCategory::getInstance()->getTable()->findAll()->toKeyValueArray('id', 'name');
		$byCategory->addMultiOptions($categories);

		$this->addElements(array(
			$byCategory,
		));
		
    }

}

