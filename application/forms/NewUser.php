<?php
class Application_Form_NewUser extends Zend_Form
{
    private $_formDecorator = array(
    	'FormElements',
    	array('HtmlTag',array('tag'=>'ul','class'=>'formTable')),
    	'Form',
    );
        
	private $_elementDecorator = array(
		array('label',array('escape'=>false)),
		'ViewHelper',
		array('errors'),
		array('htmltag',array('tag'=>'li')),
		//array('errorshtmltag',array('tag'=>'td')),
		//array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
	);
	private $_checkboxDecorator = array(
		array('ViewHelper'),
		array(array('data'=>'HtmlTag'),array('tag'=>'span')),
		array('label',array('placement'=>'prepend')),
		//'errors',
		array('HtmlTag',array('tag'=>'li')),
	);
                                    
	private $_buttonDecorator = array(
		'ViewHelper',
		//array('HtmlTag',array('tag'=>'li')),
		//array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
	);
	
    public function init()
    {
    	//$this->addElementPrefixPath('My_Form_Decorator', 'my/forms/decorators', 'decorator');
    	$this->setDecorators($this->_formDecorator);
    	$this->setName('user_form');
		$this->setMethod('post');
		$this->setAttribs(array(
			'dojoType'	=>	'dijit.form.Form',
			'id'		=>	'user_form',
		));
		/*
		$this->setDecorators(array(
            'formelements',
			array('htmltag', array('tag' => 'table')),
			'form',
        ));
        */
        $email = new Zend_Form_Element_Text('email',array(
        	'label'		=>	'อีเมล์สำหรับล็อกอิน',
        	'required'	=>	true,
        	'decorators'	=>	$this->_elementDecorator,
        	'validators'	=> array('EmailAddress'),
        ));
        $email->setAttribs(array(
        	'dojoType'	=>	'dijit.form.ValidationTextBox',
	        'lowerCase'	=>	true,
	        'trim'		=>	true,
        	'required'	=>	true,
        	'maxLength'	=>	'100',
        	'validator'	=>	'dojox.validate.isEmailAddress',
        	'invalidMessage'	=>	'กรอกอีเมล์ตามรูปแบบที่ถูกต้อง เช่น member@athingbook.com',
        ));

        $password = new Zend_Form_Element_Password('password',array(
        	'label'	=>	'รหัสผ่านสำหรับล็อกอิน',
        	'maxlength'	=>	'25',
        	'required'=>	true,
        	'decorators'=>	$this->_elementDecorator,
        ));
        $password->setAttribs(array(
        	'dojoType'	=>	'dijit.form.ValidationTextBox',
        	'required'	=>	true,
        	'validator'	=>	'dojox.validate.isText',
        ));

        $repassword = new Zend_Form_Element_Password('repassword',array(
        	'label'	=>	'ยืนยันรหัสผ่าน',
        	'maxlength'	=>	'25',
        	'required'=>	true,
        	'decorators'=>	$this->_elementDecorator,
        ));
        $repassword->setAttribs(array(
        	'dojoType'	=>	'dijit.form.ValidationTextBox',
        	'required'	=>	true,
        	'validator'	=>	'dojox.validate.isText',
        ));
        
        $role = new Zend_Form_Element_Select('role_id',array(
        	'label'	=>	'บทบาท',
        	'multiOptions'	=> Model_Role::getInstance()->getTable()->findAll('key_value_pair'),
        	'value'	=>	2,
        	'required'=>	true,
        	'decorators'=>	$this->_elementDecorator,
        ));
        $role->setAttribs(array(
        	'dojoType'	=>	'dijit.form.Select',
        	'required'	=>	true,
        ));
        
        $alias = new Zend_Form_Element_Text('alias',array(
        	'label'	=>	'นามแฝง',
        	'maxlength'	=>	'20',
        	'required'=>	true,
        	'decorators'=>	$this->_elementDecorator,
        ));
        $alias->setAttribs(array(
        	'dojoType'	=>	'dijit.form.ValidationTextBox',
        	'required'	=>	true,
        	'validator'	=>	'dojox.validate.isText',
        ));
        
        $firstname = new Zend_Form_Element_Text('first_name',array(
        	'label'		=>	'ชื่อ',
        	'maxlength'	=>	'25',
        	'required'	=>	true,
        	'decorators'=>	$this->_elementDecorator,
        ));
        $firstname->setAttribs(array(
        	'dojoType'	=>	'dijit.form.ValidationTextBox',
        	'required'	=>	true,
        	'validator'	=>	'dojox.validate.isText',
        ));

        $lastname = new Zend_Form_Element_Text('last_name',array(
        	'label'	=>	'นามสกุล',
        	'maxlength'	=>	'25',
        	'required'=>	true,
        	'decorators'=>	$this->_elementDecorator,
        ));
        $lastname->setAttribs(array(
        		'dojoType'	=>	'dijit.form.ValidationTextBox',
        		'required'	=>	true,
        		'validator'	=>	'dojox.validate.isText',
        ));

        $gender = new Zend_Form_Element_Radio('gender',array(
        	'label'	=>	'เพศ',
        	'multiOptions'	=>	array(
        		'm'	=>	'ชาย',
        		'f'	=>	'หญิง',
        	),
        	'dojoType'	=>	'dijit.form.RadioButton',
        	'separator'	=>	' ',
        	//'required'=>	true,
        ));
		$gender->clearDecorators()->setDecorators($this->_checkboxDecorator);

		$birthday = new Zend_Form_Element_Text('birthday', array(
			'label'	=>	'วันเกิด <span class="remark">(วว/ดด/ปปปป)</span>',
			//'required'=>	true,
			'decorators'=>	$this->_elementDecorator,
		));
		$birthday->setAttribs(array(
			'dojoType'	=>	'dijit.form.DateTextBox',
			//'required'=>	true,
		));
		
		$address = new Zend_Form_Element_Textarea('address', array(
			'label'	=>	'ที่อยู่ปัจจุบัน',
			'rows'	=>	'3',
			'cols'	=>	'25',
			'maxlength'	=>	'150',
			'decorators'=>	$this->_elementDecorator,
		));
		$address->setAttribs(array(
			'dojoType'	=>	'dijit.form.Textarea',
		));
		
		$subdistrict = new Zend_Form_Element_Text('subdistrict',array(
        	'label'	=>	'แขวง/ตำบล',
        	'maxlength'	=>	'25',
        	'decorators'=>	$this->_elementDecorator,
        ));
		$subdistrict->setAttribs(array(
			'dojoType'	=>	'dijit.form.TextBox',
		));
		
        $district = new Zend_Form_Element_Text('district',array(
        	'label'	=>	'เขต/อำเภอ',
        	'maxlength'	=>	'25',
        	'decorators'=>	$this->_elementDecorator,
        ));
        $district->setAttribs(array(
        	'dojoType'	=>	'dijit.form.TextBox',
        ));
        
        $province = new Zend_Form_Element_Select('province',array(
        	'label'	=>	'จังหวัด',
        	'multiOptions'	=> My_Data_Province::getInstance()->getAll(),
        	'decorators'=>	$this->_elementDecorator,
        	'value'	=>	10,
        ));
        $province->setAttribs(array(
        	'dojoType'	=>	'dijit.form.FilteringSelect',
        	'placeHolder'	=>	'ระบุจังหวัด',
        ));

        $zipcode = new Zend_Form_Element_Text('zipcode',array(
        	'label'	=>	'รหัสไปรษณีย์',
        	'maxlength'	=>	'5',
        	'decorators'=>	$this->_elementDecorator,
        ));
        $zipcode->setAttribs(array(
        	'dojoType'	=>	'dijit.form.ValidationTextBox',
        ));
        
        $telephone = new Zend_Form_Element_Text('telephone',array(
        	'label'	=>	'เบอร์บ้าน',
        	'maxlength'	=>	'10',
        	'decorators'=>	$this->_elementDecorator,
        ));
        $telephone->setAttribs(array(
        	'dojoType'	=>	'dijit.form.ValidationTextBox',
        ));
        
        $mobilephone = new Zend_Form_Element_Text('mobilephone',array(
        	'label'	=>	'เบอร์มือถือ',
        	'maxlength'	=>	'10',
        	'decorators'=>	$this->_elementDecorator,
        ));
        $mobilephone->setAttribs(array(
        	'dojoType'	=>	'dijit.form.ValidationTextBox',
        ));
        
        $newsletter = new Zend_Form_Element_Radio('news_letter_allowed',array(
        	'label'	=>	'ต้องการรับข่าวสารทางอีเมล์?',
        	'multiOptions'	=>	array(
        		'1'	=>	'ต้องการ',
        		'0'	=>	'ไม่ต้องการ'
        	),
        	'value'	=>	true,
        	'separator'	=>	'',
        	'required'=>	true,
        ));
        $newsletter->setAttribs(array(
        	'dojoType'	=>	'dijit.form.RadioButton',
        	'required'=>	true,
        ));
		$newsletter->clearDecorators()->setDecorators($this->_checkboxDecorator);
		
		$submit = new Zend_Form_Element_Button('send',array(
			'value'	=>	1,
       		'decorators'=>	$this->_buttonDecorator,
        ));
        $submit->setAttribs(array(
        	'dojoType'	=>	'dojox.form.BusyButton',
        	//'dojoType'	=>	'dijit.form.Button',
        	'label'	=>	'เพิ่มสมาชิกใหม่',
        	'type'	=>	'submit',
        	'busyLabel'	=>	'กำลังส่งข้อมูล...',
        	//'timeout'	=>	5000,
        ));
        $this->addElements(array(
        	$email,
        	$password,
        	$repassword,
        	$role,
        	$firstname,
        	$lastname,
        	$alias,
        	$gender,
        	$birthday,
        	$address,
        	$subdistrict,
        	$district,
        	$province,
        	$zipcode,
        	$telephone,
        	$mobilephone,
        	$newsletter,
        	$submit,
        ));
       
    }
}

