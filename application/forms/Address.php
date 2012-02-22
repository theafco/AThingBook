<?php
class Application_Form_Address extends Application_Form_FormBase
{
    
    public function init()
    {
		$address = new Zend_Dojo_Form_Element_Textarea('address', array(
			'label'	=>	'ที่อยู่ปัจจุบัน',
			'rows'	=>	'3',
			'cols'	=>	'25',
			'Maxlength'	=>	'150',
			'Required'	=>	true,
			'Trim'	=>	true,
		));
		
		$subdistrict = new Zend_Dojo_Form_Element_ValidationTextBox('subdistrict',array(
        	'label'	=>	'แขวง/ตำบล',
        	'maxlength'	=>	'25',
			'Required'	=>	true,
			'Trim'	=>	true,
        ));
		
        $district = new Zend_Dojo_Form_Element_ValidationTextBox('district',array(
        	'label'	=>	'เขต/อำเภอ',
        	'maxlength'	=>	'25',
        	'Required'	=>	true,
        	'Trim'	=>	true,
        ));
        
        $province = new Zend_Dojo_Form_Element_FilteringSelect('province_code',array(
        	'label'	=>	'จังหวัด',
        	'multiOptions'	=> My_Data_Province::getInstance()->getAll(),
        	'Value'	=>	10,
        	'Required'	=>	true,
        	'dijitParams'	=>	array(
        		'placeHolder'	=>	'ระบุจังหวัด',
        	),
        ));

        $zipcode = new Zend_Dojo_Form_Element_ValidationTextBox('zipcode',array(
        	'label'	=>	'รหัสไปรษณีย์',
        	'maxlength'	=>	'5',
        	'Required'	=>	true,
        	'Trim'	=>	true,
        	'dijitParams'	=>	array(
        		'regExp'	=>	'\d{5}',
        	),
        ));

        $this->addElements(array(
        	$address,
        	$subdistrict,
        	$district,
        	$province,
        	$zipcode,
        ));
       
    }
}

