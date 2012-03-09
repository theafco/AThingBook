<?php
// include_once APPLICATION_PATH . '/../public/ckeditor/ckeditor.php';
// include_once APPLICATION_PATH . '/../public/ckfinder/ckfinder.php';
class Shop_Form_Product extends Application_Form_FormBase
{
    private $_categoryModel;
    
    public function __construct() {
    	$this->_categoryModel = new Model_ProductCategory();
    	parent::__construct();
    }
    
    public function init()
    {
        $this->setEnctype('multipart/form-data');

        $name = new Zend_Dojo_Form_Element_ValidationTextBox('name',array(
        	'label'		=>	'ชื่อสินค้า',
        	'maxLength'	=>	'50',
        	'required'	=>	true,
        	'dijitParams'	=>	array(
        		'trim'		=>	true,
        	),
        	'filters'	=>	$this->_textFormElementFilters,
        ));

        $description = new Zend_Dojo_Form_Element_Textarea('description',array(
        	'label'	=>	'รายละเอียดสินค้า',
        	'maxLength'	=>	'100',
        	'required'	=>	true,
        	'dijitParams'	=>	array(
        		'trim'	=>	true,
        		'style'		=>	'width:250px',
        	),
        	'filters'	=>	$this->_textFormElementFilters,
        ));
        
        $configs = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('files');
        $thumbnail = new Zend_Form_Element_File('thumbnail',array(
        	'label'	=>	'รูปสินค้า',
        	'description'	=>	'รองรับไฟล์ประเภท jpg,png หรือ gif',
        	'destination'	=>	$configs['image_upload_path'],
        	'validators'	=>	array(
	        	array('Count',false,array('max'=>1)),
	        	array('Size',false,array('max'=>1024000)),
	        	array('Extension',false,array('extension'=>'jpg,png,gif'))
        	),
        ));
        $thumbnail->setValueDisabled(false);
        
        $normalPrice = new Zend_Dojo_Form_Element_CurrencyTextBox('normal_price',array(
        	'label'	=>	'ราคาขายปกติ',
        	'maxLength'	=>	10,
        	'required'=>	true,
        ));
        
        $salePrice = new Zend_Dojo_Form_Element_CurrencyTextBox('sale_price',array(
        	'label'	=>	'ราคาขายพิเศษ',
        	'maxLength'	=>	10,
        ));
        
        $category = new Zend_Form_Element_Select('category_id',array(
        	'label'		=>	'หมวดสินค้า',
        	'required'	=>	true,
        	'multiOptions'	=> $this->_categoryModel->findAll()->toKeyValueArray('id', 'name'),
        ));
        $category->setAttribs(array(
        	'dojoType'	=>	'dijit.form.Select',
        ));
        $this->_dojoHelper->dojo()->requireModule(array('dijit.form.Select'));
        
        $content = new Zend_Form_Element_Textarea('content',array(
        	'label'		=>	'รายละเอียดสินค้า',
        	'attribs'	=>	array(
        			'class'	=>	'ckeditor',
        	),
        	'filters'	=>	array('StripSlashes','StringTrim')
        ));
//         $content = new CKEditor();
//         $content->basePath = '/ckeditor/';
        
        $release = new Zend_Dojo_Form_Element_RadioButton('is_released',array(
        	'Label'	=>	'สถานะการขาย',
        	'multiOptions'	=>	array('1'=>'เปิดการขาย','0'=>'ปิดการขาย'),
        	'required'	=>	true,
        	'separator'	=>	' ',
        ));
        
        $this->addElements(array(
        	$category,
        	$name,
        	$thumbnail,
        	$description,
        	$normalPrice,
        	$salePrice,
        	$content,
        	$release,
        ));
        
        parent::init();
    }

}

