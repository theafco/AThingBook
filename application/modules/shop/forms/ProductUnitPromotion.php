<?php
class Shop_Form_ProductUnitPromotion extends Application_Form_Editor
{

	public function init()
	{
		parent::init();
		
		$inputValue = new Zend_Dojo_Form_Element_NumberTextBox('in_value',array(
			'label'		=>	'ซื้อจำนวนชิ้น',
// 			'required'	=>	true,
			'style'		=>	'width:60px',
			'decorators'	=>	array(
				'dijitElement',
				array(array('elemDdOpen'=>'HtmlTag'),array('tag'=>'dd','openOnly'=>true)),
				array('label',array('tag'=>'dt')),
			),
		));

		$outputType = new Zend_Form_Element_Select('out_type_id',array(
// 			'required'	=>	true,
			'multiOptions'	=>	array(
				1=>'ราคาหน่วยละ',
				2=>'ลดราคาเหลือ',
			),
			'decorators'	=>	array('viewHelper'),
		));
		$outputType->setAttribs(array(
			'dojoType'	=>	'dijit.form.Select',
			'style'	=>	'width:100px',
		));
		$this->_dojoHelper->dojo()->requireModule(array('dijit.form.Select'));
		
		$outputValue = new Zend_Dojo_Form_Element_NumberTextBox('out_value',array(
// 			'required'	=>	true,
			'style'	=>	'width:60px',
			'decorators'	=>	array(
				'dijitElement',
				array(array('elemDdClose'=>'HtmlTag'),array('tag'=>'dd','closeOnly'=>true)),
			),
		));

		$this->addElements(array(
			$inputValue,
			$outputType,
			$outputValue,
		));

		$this->addSubmitButton();
	}

}
