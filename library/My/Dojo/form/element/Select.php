<?php

class My_Dojo_Form_Element_Select extends Zend_Dojo_Form_Element_ComboBox
{
	/**
     * Use FilteringSelect dijit view helper
     * @var string
     */
    public $helper = 'Select';
	//public $helper = 'FilteringSelect';
    /**
     * Flag: autoregister inArray validator?
     * @var bool
     */
    protected $_registerInArrayValidator = true;
}
?>