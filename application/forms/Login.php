<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        
        $identity = new Zend_Form_Element_Text('email',array(
        		'label'		=>	'อีเมล์',
        		'required'	=>	true,
        	));
        
        $password = new Zend_Form_Element_Password('password',array(
        		'label'		=>	'รหัสผ่าน',
        		'required'	=>	true,
        	));
        	
        $submit = new Zend_Form_Element_Submit('submit',array(
        		'label'		=>	'เข้าสู่ระบบ'
        	));
        
        $this->addElements(array(
        	$identity,
        	$password,
        	$submit
        ));
    }

}

