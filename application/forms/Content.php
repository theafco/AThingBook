<?php
class Application_Form_Content extends Zend_Form
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
		$this->setName('content_form');
		$this->setAttribs(array(
			'id'		=>	'content_form',
			'dojoType'	=>	'dijit.form.Form',
			'enctype'	=>	'multipart/form-data',
		));
		
		$format = new Zend_Form_Element_Radio('format',array(
				'label'	=>	'รูปแบบหลัก',
				'multiOptions'	=>	array(
	        		'0'	=>	'ข้อความ',
	        		'1'	=>	'รูปภาพ',
        		),
				'separator'	=>	' ',
				'required'=>	true,
				'decorators'=>	$this->_elementDecorator,
		));
		$format->setAttribs(array(
				'dojoType'	=>	'dijit.form.RadioButton',
		));
		$format->clearDecorators()->setDecorators($this->_checkboxDecorator);
		
        $name = new Zend_Form_Element_Text('name',array(
        	'label'	=>	'ชื่อหัวข้อ',
        	'maxLength'	=>	'100',
        	'required'=>	true,
        	'decorators'=>	$this->_elementDecorator,
        ));
        $name->setAttribs(array(
        	'dojoType'	=>	'dijit.form.ValidationTextBox',
        	'required'	=>	true,
        	'trim'		=>	true,
        ));

        $thumbnail = new Zend_Form_Element_File('thumbnail',array(
        	'label'	=>	'ภาพสื่อเนื้อหา',
        	'destination'	=>	APPLICATION_PATH . '/../public/uploads',
        ));
        $thumbnail->setDecorators(array(
        	'File',
        	'Errors',
        	'Label',
        	array('HtmlTag',array('tag'=>'li')),
        ));
		$thumbnail->addValidators(array(
			array('Count',false,array('max'=>1)),
			array('Size',false,array('max'=>1024000)),
			array('Extension',false,array('extension'=>'jpg'))
		));
		$thumbnail->setValueDisabled(false);
		
        $category = new Zend_Form_Element_Select('category_id',array(
        	'label'		=>	'หมวดหมู่',
        	'required'	=>	true,
        	'decorators'=>	$this->_elementDecorator,
        ));
        $category->addMultiOptions(Model_ContentCategory::getInstance()->getTable()->findAll()->toKeyValueArray('id', 'name'));
        $category->setAttribs(array(
        	'dojoType'	=>	'dijit.form.Select',
        	'required'=>	true,
        ));
        
        $submit = new Zend_Form_Element_Button('send',array(
			'value'	=>	1,
       		'decorators'=>	$this->_buttonDecorator,
        ));
        $submit->setAttribs(array(
        	'dojoType'	=>	'dojox.form.BusyButton',
        	//'dojoType'	=>	'dijit.form.Button',
        	'label'	=>	'หน้าถัดไป',
        	'type'	=>	'submit',
        	'busyLabel'	=>	'กำลังส่งข้อมูล...',
        	//'timeout'	=>	5000,
        ));
        
        $this->addElements(array(
        	$format,
        	$category,
        	$name,
       		$thumbnail,
        	$submit,
        ));
    }


}

