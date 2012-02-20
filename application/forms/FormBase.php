<?php
class Application_Form_FormBase extends Zend_Dojo_Form
{
    protected $_submitButton = null;
    
//     protected $_elementDecorators = array(
//     		array('label',array('escape'=>false)),
//     		'ViewHelper',
//     		array('errors'),
//     		array('htmltag',array('tag'=>'li')),
//     		//array('errorshtmltag',array('tag'=>'td')),
//     		//array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
//     );
//     protected $_dojoElementDecorators = array(
//     		'DijitElement',
//     		array('Errors'),
//     		array('Description'),
//     		array('HtmlTag',array('tag'=>'li')),
//     		array('Label',array('escape'=>false)),
//     		//array('errorshtmltag',array('tag'=>'td')),
//     		//array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
//     );
//     protected $_checkboxDecorators = array(
//     		array('ViewHelper'),
//     		array(array('data'=>'HtmlTag'),array('tag'=>'span')),
//     		array('label',array('placement'=>'prepend')),
//     		//'errors',
//     		array('HtmlTag',array('tag'=>'li')),
//     );
    
//     protected $_buttonFormElementDecorators = array(
//     		'ViewHelper',
//     		//array('HtmlTag',array('tag'=>'li')),
//     		//array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
//     );
    
    protected $_textFormElementFilters = array(
	    array('StripSlashes'),
	    array('StripTags'),
	    array('StringTrim'),
    );
    
    public function __construct()
    {
        $this->addElementPrefixPath('My_Filter','My/Filter','filter');

        $this->_submitButton = new Zend_Form_Element_Button('send');
        $this->_submitButton->setAttribs(array(
        		'dojoType'	=>	'dojox.form.BusyButton',
        		'type'	=>	'submit',
        		'busyLabel'	=>	'กำลังส่งข้อมูล...',
        ));
        
//         parent::__construct(array(
//         	'decorators'	=>	array(
// 	        	'FormElements',
// 	        	array('HtmlTag',array('tag'=>'ul','class'=>'formTable')),
// 	        	'DijitForm',
//         	),
//         ));
		parent::__construct();

    }
	/**
	 * 
	 * @param string $label
	 * 
	 * @return Zend_Form_Element_Button
	 */
    public function getSubmitButton($label=null){
        if(!empty($label)) {
            $this->_submitButton->setLabel($label);
        }
        return $this->_submitButton;
    }
}
?>