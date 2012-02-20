<?php

class Application_Form_UserSearchWithFilter extends Application_Form_Search
{

    public function init()
    {
    	parent::init();
    	$this->setName('user_search');
    	$this->setMethod('get');

    	$this->setDecorators(array(
			array('ViewScript',array('viewScript'=>'forms/user_search_with_filter.phtml')),
		));
		
		$searchby = $this->getElement('by')->setMultiOptions(array(
			'id'=>'รหัสประจำตัว',
			'name'=>'ชื่อจริง',
			'alias'=>'นามแฝง',
			'email'=>'อีเมล์'
		));

		$byGender = new Zend_Form_Element_Select('gender',array(
			'label'		=>	'เพศ:',
			'dojoType'	=>	'dijit.form.Select',
			'multioptions'	=>	array(
									''	=>	'ทุกเพศ',
									'm'	=>	'ผู้ชาย',
									'f'	=>	'ผู้หญิง',
								),
			'order'		=>	2,
			'Filters'	=>	$this->_elementFilters,
			'Decorators'=>	$this->_elementDecorators,
		));

		$byRole = new Zend_Form_Element_Select('role',array(
			'label'		=>	'บทบาท:',
			'dojoType'	=>	'dijit.form.Select',
			'multioptions'	=>	array(
									''	=>	'ทุกบทบาท',
								),
			'order'		=>	3,
			'Filters'	=>	$this->_elementFilters,
			'Decorators'=>	$this->_elementDecorators,
		));
		$roles = Model_Role::getInstance()->getTable()->findAll()->toKeyValueArray('id', 'name');
		$byRole->addMultiOptions($roles);
		
		$this->addElements(array(
			$byGender,
			$byRole,
		));
		
    }

}

