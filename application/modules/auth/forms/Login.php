<?php

class Auth_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('loginForm');
        
        $identity = new Zend_Form_Element_Text('identity',array(
        	'label'		=>	'อีเมล์',
        ));
        
        $password = new Zend_Form_Element_Password('password',array(
        	'label'		=>	'รหัสผ่าน',
        ));
        
        $submit = new Zend_Form_Element_Submit('login',array(
        	'label'		=>	'เข้าสู่ระบบ'
        ));
        
        $this->addElements(array(
        	$identity,
        	$password,
        	$submit,
        ));
    }

}

