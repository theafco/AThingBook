<?php
class Application_Form_Address extends Application_Form_FormBase
{
    public function init()
    {
		$address1 = new Zend_Dojo_Form_Element_Textarea('address1', array(
			'label'	=>	'ที่อยู่ปัจจุบัน',
			'rows'	=>	'3',
			'cols'	=>	'25',
			'maxLength'	=>	'150',
			'required'	=>	true,
			'trim'	=>	true,
		));
		
		$subdistrict = new Zend_Dojo_Form_Element_ValidationTextBox('subdistrict',array(
        	'label'	=>	'แขวง/ตำบล',
        	'maxLength'	=>	'25',
			'required'	=>	true,
			'trim'	=>	true,
        ));
		
        $district = new Zend_Dojo_Form_Element_ValidationTextBox('district',array(
        	'label'	=>	'เขต/อำเภอ',
        	'maxLength'	=>	'25',
        	'required'	=>	true,
        	'trim'	=>	true,
        ));
        
        $province = new Zend_Dojo_Form_Element_FilteringSelect('province_code',array(
        	'label'	=>	'จังหวัด',
        	'multiOptions'	=> My_Data_Province::getInstance()->getAll(),
        	'value'	=>	10,
        	'required'	=>	true,
        	'dijitParams'	=>	array(
        		'placeHolder'	=>	'ระบุจังหวัด',
        	),
        ));

        $zipcode = new Zend_Dojo_Form_Element_ValidationTextBox('zipcode',array(
        	'label'	=>	'รหัสไปรษณีย์',
        	'maxLength'	=>	'5',
        	'required'	=>	true,
        	'dijitParams'	=>	array(
        		'trim'	=>	true,
        		'validator'	=>	'dojox.validate.us.isZipCode',
        	),
        ));
        $this->_dojoHelper->dojo()->requireModule('dojox.validate.us');

        $this->addElements(array(
        	$address1,
        	$subdistrict,
        	$district,
        	$province,
        	$zipcode,
        ));
       
    }
}

