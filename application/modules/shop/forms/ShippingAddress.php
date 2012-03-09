<?php
class Shop_Form_ShippingAddress extends Application_Form_FormBase
{
    public function init()
    {
        $shippingName = new Zend_Dojo_Form_Element_ValidationTextBox('shipping_name',array(
        	'label'	=>	'ชื่อผู้รับ',
        	'required'	=>	true,
        	'filters'	=>	$this->_textFormElementFilters,
        	'dijitParams'	=> array(
        		'trim'		=>	true,
        		'maxlength'	=>	100,
        	),
        ));
        $address = new Application_Form_Address();
        $address->removeDecorator('HtmlTag');
        
        $this->addElement($shippingName);
        $this->addSubForm($address,'shippingAddress');
        
        parent::init();
        $this->send->setAttribs(array('label'=>'ยืนยันการสั่งซื้อ'));

    }
}
?>