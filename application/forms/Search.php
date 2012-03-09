<?php

class Application_Form_Search extends Application_Form_FormBase
{
    /**
     * 
     * @var Zend_Dojo_View_Helper_Dojo
     */
    protected $_dojoHelper;
    
    public function __construct()
    {
        $this->_dojoHelper = new Zend_Dojo_View_Helper_Dojo();
        
        parent::__construct();
    }
    
    public function init()
    {
        parent::init();
        
        $this->setMethod('get');
        $this->setName('searchForm');

        $this->removeElement('send');
        
		$keyword = new Zend_Dojo_Form_Element_TextBox('keyword',array(
			'filters'	=>	array('StripSlashes'),
			'dijitParams'	=>	array(
				'trim'			=>	true,
				'placeHolder'	=>	'คำค้นหา',
				'style'	=>	'width:160px',
			),
		));

		$searchby = new Zend_Form_Element_Select('searchBy',array(
			'label'		=>	'ค้นหาโดย',
		));
		$searchby->setAttribs(array(
			'dojoType'	=>	'dijit.form.Select',
		));
		$this->_dojoHelper->dojo()->requireModule(array('dijit.form.Select'));

		$this->addElements(array(
			$keyword,
			$searchby,
		));

    }
    
    public function addSubmitButton()
    {
        $submit = new Zend_Dojo_Form_Element_SubmitButton('search',array(
        		'label'	=>	'เริ่มค้นหา',
        ));
        $this->addElement($submit);
    }

}

