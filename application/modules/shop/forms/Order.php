<?php 
class Shop_Form_Order extends Application_Form_FormBase
{
    protected $_elementFilters = array('StringTrim','StringToLower');
    protected $_elementDecorators = array(
    		'Label',
    		'ViewHelper',
    );
    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('orderForm');
        $this->setAttribs(array(
        	'id'		=>	'orderForm',
        	'dojoType'	=>	'dijit.form.Form',
        ));
        
        $quantity = new Zend_Form_Element_Text('quantity',array(
        	'Label'	=>	'จำนวนเล่ม',
        	'Value'	=>	1,
        ));
        $quantity->setAttribs(array(
        	'dojoType'		=>	'dijit.form.NumberSpinner',
        	'style'			=>	'width:100px',
        	'smallDelta'	=>	1,
        	'constraints'	=>	'{min:1,places:0}',
        ));
        
        $submit = new Zend_Form_Element_Button('send',array(
        	'Label'	=>	'สั่งซื้อ',
        ));
        $submit->setAttribs(array(
        	'dojoType'	=>	'dojox.form.BusyButton',
	        'type'	=>	'submit',
	        'busyLabel'	=>	'กำลังส่งข้อมูล...',
        ));
        
		$this->addElements(array(
			$quantity,
		));
		
		parent::init();
    }

}
