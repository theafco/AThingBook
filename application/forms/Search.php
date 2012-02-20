<?php

class Application_Form_Search extends Zend_Form
{
    protected $_elementFilters = array('StringTrim','StringToLower');
    protected $_elementDecorators = array(
    		'Label',
    		'ViewHelper',
    );
    
    public function init()
    {
        $this->setMethod('get');
        $this->setName('search_form');
        $this->setAttribs(array(
        	'dojoType'	=>	'dijit.form.Form',
        ));
        /*$this->setDecorators(array(
        	'FormElements'
        ));*/
        /*
        $keywordDecorators = array(
			array('DijitElement'),
			array('HtmlTag', array('tag' => 'div','class'=>'searchBox')),
		);
        */
		$keyword = new Zend_Form_Element_Text('keyword',array(
			//'class'			=>	'searchBox',
			'Filters'		=>	$this->_elementFilters,
			//'decorators'	=>	$keywordDecorators,
		));
		$keyword->setAttribs(array(
			'dojoType'		=>	'dijit.form.TextBox',
			'trim'			=>	true,
			'placeHolder'	=>	'คำค้นหา'
		));
/*
		$submit = new Zend_Dojo_Form_Element_Button('searchSubmit','ค้นหา',array(
			'Label'	=>	'ค้นหา',
		));
		$submit->setDecorators(array(
			array('DijitElement'),
		));
*/
		$searchby = new Zend_Form_Element_Select('by',array(
			'label'		=>	'ค้นหาโดย',
			'multioptions'	=>	array(
									'id'=>'รหัสสินค้า',
									'name'=>'ชื่อสินค้า',
								),
			'order'		=>	1,
			'Filters'		=>	$this->_elementFilters,
			//'decorators'	=>	$searchByDecorators,
		));
		$searchby->setAttribs(array(
			'dojoType'	=>	'dijit.form.Select',
			'style'		=>	'width:200px',
		));

		$this->addElements(array(
			$keyword,
			$searchby
		));
    }

}

