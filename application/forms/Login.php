<?php

class Application_Form_Login extends Application_Form_FormBase
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('id', 'loginForm');
        
        $identity = new Zend_Dojo_Form_Element_TextBox('email',array(
        		'label'		=>	'อีเมล์',
        		'required'	=>	true,
        	));
        
        $password = new Zend_Dojo_Form_Element_PasswordTextBox('password',array(
        		'label'		=>	'รหัสผ่าน',
        		'required'	=>	true,
        	));
        	
        $submit = new Zend_Dojo_Form_Element_SubmitButton('submit',array(
        		'label'		=>	'เข้าสู่ระบบ'
        	));
        
        $this->addElements(array(
        	$identity,
        	$password,
        	$submit
        ));
    }

}

