<?php
class Application_Form_ShippingAddress extends Application_Form_FormBase
{

    public function init()
    {
        $shippingName = new Zend_Dojo_Form_Element_ValidationTextBox('shipping_name',array(
        	'Label'	=>	'ชื่อผู้รับ',
        	'Required'	=>	true,
        	'Trim'	=>	true,
        	'filters'	=>	$this->_textFormElementFilters,
        	'dijitParams'	=> array(
        		'Required'	=>	true,
        		'Trim'		=>	true,
        		'Maxlength'	=>	100,
        	),
        ));
        $address = new Application_Form_Address();
        $address->removeDecorator('HtmlTag');
        
        $this->addElement($shippingName);
        $this->addSubForm($address, 'shippingAddress');

        $this->addElement($this->_submitButton->setLabel('ยืนยันการสั่งซื้อ'));
    }
}
?>