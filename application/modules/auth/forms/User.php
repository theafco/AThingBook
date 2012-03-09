<?php
class Auth_Form_User extends Application_Form_FormBase
{
    private $_roleModel;
    
    public function __construct() {
        $this->_roleModel = new Model_Role();
        parent::__construct();
    }
    
    public function init()
    {
        $email = new Zend_Dojo_Form_Element_ValidationTextBox('email',array(
        	'label'		=>	'อีเมล์สำหรับล็อกอิน',
        	'required'	=>	true,
        	'validators'	=> array('EmailAddress'),
        	'dijitParams'	=>	array(
        		'trim'	=>	true,
        		'lowerCase'	=>	true,
        		'maxLength'	=>	'100',
        		'validator'	=>	'dojox.validate.isEmailAddress',
        		'invalidMessage'	=>	'ป้อนอีเมล์ที่ถูกต้อง เช่น member@athingbook.com',
        	),
        ));
        $this->_dojoHelper->dojo()->requireModule(array('dojox.validate','dojox.validate.web'));

        $password = new Zend_Dojo_Form_Element_PasswordTextBox('password',array(
        	'label'	=>	'รหัสผ่าน',
        	'maxlength'	=>	'25',
        	'required'=>	true,
        	//'filters'	=>	array('MD5'),
        	'dijitParams'	=>	array(
        		'trim'	=>	true,
        	),
        	'validators'	=>	array(
        		array('StringLength',false,array(
        			'min'	=>	5,
        			'max'	=>	25,
        			'messages'=>array(Zend_Validate_StringLength::TOO_SHORT=>'รหัสผ่านต้องมีความยาวไม่น้อยกว่า %min% ตัวอักษร'),
        		)),
        	),
        ));

        $repassword = new Zend_Dojo_Form_Element_PasswordTextBox('repassword',array(
        	'label'	=>	'ยืนยันรหัสผ่าน',
        	'maxlength'	=>	'25',
        	'required'=>	true,
        	'validators'	=> array(
        		array('Identical',false,array(
        			'token'=>'password',
        			'messages'=>array(Zend_Validate_Identical::NOT_SAME=>'รหัสผ่านไม่ตรงกัน'),
        		)),
        	),
	        'dijitParams'	=>	array(
	        		'trim'	=>	true,
	        ),
        ));

        $role = new Zend_Form_Element_Select('role_id',array(
        	'label'	=>	'บทบาท',
        	'multiOptions'	=> $this->_roleModel->findAll()->toKeyValueArray('id', 'name'),
        	'value'	=>	2,
        	'required'=>	true,
        ));
        $role->setAttribs(array(
        	'dojoType'	=>	'dijit.form.Select',
        ));
        $this->_dojoHelper->dojo()->requireModule(array('dijit.form.Select'));
        
        $alias = new Zend_Dojo_Form_Element_ValidationTextBox('alias',array(
        	'label'	=>	'นามแฝง',
        	'maxlength'	=>	'20',
        	'required'=>	true,
        	'filters'	=> $this->_textFormElementFilters,
	        'dijitParams'	=>	array(
	        		'trim'	=>	true,
	        ),
        ));

        $firstname = new Zend_Dojo_Form_Element_ValidationTextBox('first_name',array(
        	'label'		=>	'ชื่อ',
        	'maxlength'	=>	'25',
        	'required'	=>	true,
        	'filters'	=> $this->_textFormElementFilters,
	        'dijitParams'	=>	array(
	        		'trim'	=>	true,
	        ),
        ));
        
        $lastname = new Zend_Dojo_Form_Element_ValidationTextBox('last_name',array(
        	'label'	=>	'นามสกุล',
        	'maxlength'	=>	'25',
        	'required'=>	true,
       		'filters'	=> $this->_textFormElementFilters,
	        'dijitParams'	=>	array(
	        		'trim'	=>	true,
	        ),
        ));

        $gender = new Zend_Dojo_Form_Element_RadioButton('gender',array(
        	'label'	=>	'เพศ',
        	'multiOptions'	=>	array(
        		'm'	=>	'ชาย',
        		'f'	=>	'หญิง',
        	),
        	'required'	=>	true,
        	'separator'	=>	' ',
        ));

		$birthday = new Zend_Dojo_Form_Element_DateTextBox('birthday', array(
			'label'	=>	'วันเกิด <span class="remark">(วว/ดด/ปปปป)</span>',
			'required'	=>	true,
		));
		$birthday->getDecorator('Label')->setOption('escape', false);
		
		$address = new Application_Form_Address();

        $telephone = new Zend_Dojo_Form_Element_ValidationTextBox('telephone',array(
        	'label'	=>	'เบอร์บ้าน',
        	'maxlength'	=>	'10',
        	'dijitParams'	=>	array(
        		'regExp'	=>	'\\d{9,10}',
        		'invalidMessage'	=>	'ป้อนหมายเลขโทรศัพท์ด้วยตัวเลขทั้งหมด เช่น 0815431234'
        	),
        ));

        $mobilephone = new Zend_Dojo_Form_Element_ValidationTextBox('mobilephone',array(
        	'label'	=>	'เบอร์มือถือ',
        	'maxlength'	=>	'10',
	        'dijitParams'	=>	array(
	        		'regExp'	=>	'\\d{9,10}',
	        		'invalidMessage'	=>	'ป้อนหมายเลขโทรศัพท์ด้วยตัวเลขทั้งหมด เช่น 0815431234'
	        ),
        ));

        $newsletter = new Zend_Dojo_Form_Element_RadioButton('news_letter_allowed',array(
        	'label'	=>	'ต้องการรับข่าวสารทางอีเมล์?',
        	'multiOptions'	=>	array(
        		'1'	=>	'ต้องการ',
        		'0'	=>	'ไม่ต้องการ'
        	),
        	'value'	=>	true,
        	'separator'	=>	' ',
        	'required'=>	true,
        ));

        $captcha = new Zend_Form_Element_Captcha('captcha',array(
        	'captcha'	=>	array(
        		'Image',
        		'imgDir'	=>	APPLICATION_PATH . '/../public/images/captcha',
        		'font'		=>	APPLICATION_PATH . '/data/arial.ttf',
        		'wordLen'	=>	5,
        		'dotNoiseLevel'	=>	50,
        		'lineNoiseLevel'	=>	5,
        	),
        	'label'	=>	'พิมพ์ข้อความตามรูป',
        	'required'	=>	true,
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
        ));
       	$this->addElements($address->getElements());
       	$this->addElements(array(
        	$telephone,
        	$mobilephone,
        	$newsletter,
        	$captcha,
        ));
        
		parent::init();
    }
}

