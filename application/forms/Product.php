<?php
class Application_Form_Product extends Zend_Form
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

	public function __construct()
	{
	    $this->addElementPrefixPath('My_Filter','My/Filter','filter');
	    
	    $this->setElementFilters(array(
	    		array('StripSlashes'),
	    		array('StripTags'),
	    		array('StringTrim'),
	    ));
	    
	    parent::__construct();
	}
	
    public function init()
    {
        $this->setDecorators($this->_formDecorator);
    	$this->setMethod('post');
		$this->setName('product_form');
		$this->setAttribs(array(
			'dojoType'	=>	'dijit.form.Form',
			'id'		=>	'product_form',
			'enctype'	=>	'multipart/form-data',
		));
        
        $name = new Zend_Form_Element_Text('name',array(
        	'label'	=>	'ชื่อสินค้า',
        	'maxLength'	=>	'100',
        	'required'=>	true,
        	'decorators'=>	$this->_elementDecorator,
        ));
        $name->setAttribs(array(
        	'dojoType'	=>	'dijit.form.ValidationTextBox',
        	'required'=>	true,
        	'trim'		=>	true,
        ));

        $description = new Zend_Form_Element_Textarea('description',array(
        	'label'	=>	'รายละเอียดสินค้า',
        	'decorators'=>	$this->_elementDecorator,
        ));
        $description->setAttribs(array(
        	'dojoType'	=>	'dijit.form.Textarea',
        	'style'		=>	'width:300px',
        ));
        
        $thumbnail = new Zend_Form_Element_File('thumbnail',array(
        	'label'	=>	'รูปสินค้า',
        	'description'	=>	'รองรับเฉพาะ JPG',
        	'destination'	=>	APPLICATION_PATH . '/../public/uploads',
        ));
        $thumbnail->setFilters(array());
        $thumbnail->setDecorators(array(
        		'File',
        		'Description',
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
        
        $normalPrice = new Zend_Form_Element_Text('normal_price',array(
        	'label'	=>	'ราคาขายปกติ',
        	'maxLength'	=>	'11',
        	'required'=>	true,
        	'decorators'=>	$this->_elementDecorator,
        ));
        $normalPrice->setAttribs(array(
        	'dojoType'	=>	'dijit.form.CurrencyTextBox',
        	'required'=>	true,
        ));
        
        $salePrice = new Zend_Form_Element_Text('sale_price',array(
        	'label'	=>	'ราคาขายพิเศษ',
        	'maxLength'	=>	'11',
        	'decorators'=>	$this->_elementDecorator,
        ));
        $salePrice->setAttribs(array(
        	'dojoType'	=>	'dijit.form.CurrencyTextBox',
        ));
        
        $category = new Zend_Form_Element_Select('category_id',array(
        	'label'	=>	'หมวดสินค้า',
        	'required'=>	true,
        	'decorators'=>	$this->_elementDecorator,
        ));
        $category->addMultiOptions(Model_ProductCategory::getInstance()->getTable()->findAll()->toKeyValueArray('id', 'name'));
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
        	'label'	=>	'เพิ่มสินค้าใหม่',
        	'type'	=>	'submit',
        	'busyLabel'	=>	'กำลังส่งข้อมูล...',
        	//'timeout'	=>	5000,
        ));
        
        $this->addElements(array(
        	$name,
        	$description,
        	$thumbnail,
        	$normalPrice,
        	$salePrice,
        	$category,
        	$submit,
        ));
    }


}

