<?php
class Application_Form_Content1 extends Zend_Form
{
    private $_formDecorator = array(
    		'FormElements',
    		array('HtmlTag',array('tag'=>'ul','class'=>'formTable')),
    		'Form',
    );
    
    private $_elementDecorator = array(
    		array('label',array('escape'=>false)),
    		'ViewHelper',
    		array('errors'),
    		array('htmltag',array('tag'=>'li')),
    		//array('errorshtmltag',array('tag'=>'td')),
    		//array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );
    private $_checkboxDecorator = array(
    		array('ViewHelper'),
    		array(array('data'=>'HtmlTag'),array('tag'=>'span')),
    		array('label',array('placement'=>'prepend')),
    		//'errors',
    		array('HtmlTag',array('tag'=>'li')),
    );
    
    private $_buttonDecorator = array(
    		'ViewHelper',
    		//array('HtmlTag',array('tag'=>'li')),
    		//array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );
    
    public function init()
    {
        $this->setDecorators($this->_formDecorator);
        $this->setMethod('post');
        $this->setName('content1_form');
        $this->setAttribs(array(
        		'id'		=>	'content1_form',
        		'dojoType'	=>	'dijit.form.Form',
        ));

        $body = new Zend_Dojo_Form_Element_Editor('body',array(
        		'label'	=>	'เนื้อหา',
        		'required'=>	true,
        		'decorators'=>	array(
        			'dijitElement',
        			'Errors',
        			'Label',
        			array('HtmlTag',array('tag'=>'li')),
        		),
        ));
        $body->setAttribs(array(
        		'height'	=>	'200px',
        		'required'=>	true,
        ));
        
        $published = new Zend_Form_Element_Radio('is_published',array(
        	'Label'	=>	'กำหนดการเผยแพร่',
        	'multiOptions'	=>	array('1'=>'เผยแพร่ทันที','0'=>'ไม่เผยแพร่'),
        	'separator'	=>	' ',
        ));
        $published	->clearDecorators()
        			->setDecorators($this->_checkboxDecorator)
        			->setAttribs(array(
			        	'dojoType'	=>	'dijit.form.RadioButton',
			        ));
        
        $submit = new Zend_Form_Element_Button('send',array(
        		'value'	=>	1,
        		'decorators'=>	$this->_buttonDecorator,
        ));
        $submit->setAttribs(array(
        		'dojoType'	=>	'dojox.form.BusyButton',
        		//'dojoType'	=>	'dijit.form.Button',
        		'label'	=>	'บันทึกข้อมูล',
        		'type'	=>	'submit',
        		'busyLabel'	=>	'กำลังส่งข้อมูล...',
        		//'timeout'	=>	5000,
        ));
        
        $this->addElements(array(
        	$body,
        	$published,
       		$submit,
        ));
        
    }
}
?>