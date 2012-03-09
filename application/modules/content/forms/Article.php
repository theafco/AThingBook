<?php
class Content_Form_Article extends Application_Form_FormBase
{
    private $_categoryModel;
    
    public function __construct() {
    	$this->_categoryModel = new Model_ArticleCategory();
    	parent::__construct();
    }
    
    public function init()
    {
        $this->setEnctype('multipart/form-data');

        $name = new Zend_Dojo_Form_Element_ValidationTextBox('name',array(
        	'label'		=>	'ชื่อหัวข้อ',
        	'maxLength'	=>	100,
        	'required'	=>	true,
        	'dijitParams'	=>	array(
        		'trim'	=>	true,
        	),
        	'filters'	=>	$this->_textFormElementFilters,
        ));
        
        $description = new Zend_Dojo_Form_Element_Textarea('description',array(
        	'label'	=>	'คำอธิบาย',
        	'maxLength'	=>	255,
        	'required'	=>	true,
        	'dijitParams'	=>	array(
        		'trim'	=>	true,
        		'style'	=>	'width:250px',
        	),
        	'filters'	=>	$this->_textFormElementFilters,
        ));
        
        $configs = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('files');
        $thumbnail = new Zend_Form_Element_File('thumbnail',array(
        	'label'	=>	'ภาพสื่อเนื้อหา',
        	'description'	=>	'รองรับไฟล์ประเภท jpg,png หรือ gif',
        	'destination'	=>	$configs['image_upload_path'],
	        'validators'	=>	array(
	        		array('Count',false,array('max'=>1)),
	        		array('Size',false,array('max'=>1024000)),
	        		array('Extension',false,array('extension'=>'jpg,png,gif'))
	        ),
        ));
		$thumbnail->setValueDisabled(false);
		
        $category = new Zend_Form_Element_Select('category_id',array(
        	'label'		=>	'หมวดหมู่',
        	'required'	=>	true,
        ));
        $category->addMultiOptions($this->_categoryModel->findAll()->toKeyValueArray('id', 'name'));
        $category->setAttribs(array(
        	'dojoType'	=>	'dijit.form.Select',
        ));
        $this->_dojoHelper->dojo()->requireModule(array('dijit.form.Select'));
        
        $body = new Zend_Form_Element_Textarea('body',array(
        	'label'		=>	'เนื้อหา',
        	'required'	=>	true,
        	'attribs'	=>	array(
        		'class'	=>	'ckeditor',
        	),
        	'filters'	=>	array('StripSlashes','StringTrim'),
        ));
        
        $published = new Zend_Dojo_Form_Element_RadioButton('is_published',array(
        	'label'	=>	'กำหนดการเผยแพร่',
        	'multiOptions'	=>	array('1'=>'เผยแพร่ทันที','0'=>'ไม่เผยแพร่'),
        	'required'	=>	true,
        	'separator'	=>	' ',
        ));
        
        $this->addElements(array(
        	$category,
        	$name,
        	$description,
       		$thumbnail,
	        $body,
	        $published,
        ));
        
        parent::init();
        
        $this->send->setAttrib('label','ดำเนินการขั้นต่อไป');
    }


}

