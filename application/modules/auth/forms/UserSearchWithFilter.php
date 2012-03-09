<?php

class Auth_Form_UserSearchWithFilter extends Application_Form_Search
{

    public function init()
    {
    	parent::init();
		
		$this->searchBy->setMultiOptions(array(
			'id'=>'รหัสผู้ใช้',
			'name'=>'ชื่อจริง',
			'alias'=>'นามแฝง',
			'email'=>'อีเมล์'
		));

		$byGender = new Zend_Form_Element_Select('gender',array(
			'label'		=>	'เพศ:',
			'dojoType'	=>	'dijit.form.Select',
			'multiOptions'	=>	array(
									''	=>	'ทุกเพศ',
									'm'	=>	'ผู้ชาย',
									'f'	=>	'ผู้หญิง',
								),
		));

		$byRole = new Zend_Form_Element_Select('role',array(
			'label'		=>	'บทบาท:',
			'dojoType'	=>	'dijit.form.Select',
			'multiOptions'	=>	array(
									''	=>	'ทุกบทบาท',
								),
		));
		$roleModel = new Model_Role();
		$roles = $roleModel->findAll()->toKeyValueArray('id', 'name');
		$byRole->addMultiOptions($roles);

		$this->addElements(array($byGender,$byRole));
		
		parent::addSubmitButton();

    }

}

