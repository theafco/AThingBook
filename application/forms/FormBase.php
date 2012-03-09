<?php
class Application_Form_FormBase extends Zend_Dojo_Form
{
    /**
     *
     * @var Zend_Dojo_View_Helper_Dojo
     */
    protected $_dojoHelper = null;
    
    protected $_textFormElementFilters = array(
	    array('StripSlashes'),
	    array('StripTags'),
	    array('StringTrim'),
    );
    protected $_hiddenFormElementDecorators = array(
    	array('ViewHelper'),
    );
    
    public function __construct()
    {
        $this->_dojoHelper = new Zend_Dojo_View_Helper_Dojo();
        $this->addElementPrefixPath('My_Filter','My/Filter','filter');
        
		parent::__construct();
    }
    
    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('class', 'form');
        $submit = new Zend_Form_Element_Button('send');
        $submit->setAttribs(array(
        		'label'	=>	'ดำเนินการ',
        		'dojoType'	=>	'dojox.form.BusyButton',
        		'type'	=>	'submit',
        		'busyLabel'	=>	'กำลังส่งข้อมูล...',
        ));
        $this->_dojoHelper->dojo()->requireModule('dojox.form.BusyButton');
        $this->addElement($submit);
    }
}
?>