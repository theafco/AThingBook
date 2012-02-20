<?php
class Admin_ProductController extends Zend_Controller_Action
{
    private $product_model;
    
    /***
     * Return product thumbnail dimensions
     * 
     * @return Array
     */
    private function getThumbnailDimensions()
    {
        $dim = array();
        $dim['small']['width'] = 148;
        $dim['small']['height'] = 104;
        
        $dim['medium']['width'] = 222;
        $dim['medium']['height'] = 156;
        
        $dim['big']['width'] = 333;
        $dim['big']['height'] = 234;
        
        return $dim;
    }
    
    public function init()
    {
        $this->product_model = new Model_Product();
        
        //Enable Dojo View Helper
        Zend_Dojo::enableView($this->view);
        
        //Create left menu
		$config = new Zend_Config_Xml(APPLICATION_PATH . '/modules/admin/configs/product_leftnav.xml','navigation');
		$container = new Zend_Navigation($config);
		$this->view->navigation($container);
		
		$uri = $this->_request->getPathInfo();
		$activeNav = $this->view->navigation()->findByUri($uri);
		$activeNav->active = true;
		
// 		$this->_helper->contextSwitch()
// 			->addActionContext('edit', array('html','json'))
// 			->setAutoJsonSerialization(true)
// 			->initContext();
    }

    public function indexAction()
    {
        $products = $this->product_model->findAll();
    	$this->view->products = $products;
    	
    	$formSearch = new Application_Form_ProductSearchWithFilter();
    	$formSearch->setAction('/admin/product/search');
    	$this->view->formSearch = $formSearch;
    }

    public function addAction()
    {
        $form = new Application_Form_Product();
    	
		if($this->getRequest()->isPost()){
			
			if($form->isValid($this->getRequest()->getPost())) {
				$product 			= 	new Model_Product();
				$product->name 		=	$form->getValue('name');
				$product->description 	=	$form->getValue('description');
				$product->normal_price 	=	(int) $form->getValue('normal_price');
				$product->sale_price 	=	(int) $form->getValue('sale_price');
				$product->category_id		=	$form->getValue('category_id');
				$product->created_date	=	date('Y-m-d H:i:s');
				$product->save();
				
				$thumbnail = $form->getElement('thumbnail');
				if($thumbnail->isUploaded()){
				    $configs = $this->getInvokeArg('bootstrap')->getOption('files');
				    $basePath = $configs['image_upload_path'] . '/products/' . $product->id . '/thumbnail';
				    $fileInfo = $thumbnail->getFileInfo();
				    $this->_helper->image->createThumbnail($basePath,$fileInfo,$this->getThumbnailDimensions());
				}
				$this->_helper->redirector('index');
				exit();
			}
		}
		
		$form->setAction($this->_helper->url('add','product','admin'));
		$this->view->form = $form;
    }

    public function viewAction()
    {
        $itemid = $this->getRequest()->getParam('item');
    	$product = $this->product_model->findOneById($itemid);
    	$this->_helper->layout()->disableLayout();
    	
    	if (false === $product){
    		return false;
    	}
    	
        $this->view->product = $product;
    }

    public function editorAction()
    {
        $itemid = $this->getRequest()->getParam('item');
    	$editor_name = $this->getRequest()->getParam('name');
    	
        $product = $this->product_model->findOneById($itemid,Doctrine_Core::HYDRATE_ARRAY);

    	//disbale layout
    	$this->_helper->layout()->disableLayout();
    	
    	//Check user
    	if(false === $product){
    		return false;
    	}

		$product_form = new Application_Form_Product();
		$form = new Zend_Form();
		
    	switch($editor_name){
    		case 'name':
    			$form	->addElement($product_form->getElement('name'));
	        	break;
    		case 'description':
    			$form	->addElement($product_form->getElement('description'));
    			break;
    		case 'thumbnail':
    			$form	->addElement($product_form->getElement('thumbnail'));
    			break;
    		case 'price':
    			$form	->addElement($product_form->getElement('normal_price'))
    					->addElement($product_form->getElement('sale_price'));
    			break;
    		case 'category':
    			$form	->addElement($product_form->getElement('category_id'));
    			break;
    	}
    	
    	$cancel_button = new Zend_Form_Element_Button('cancel',array(
    		'Decorators'	=>	array('ViewHelper'),
    	));
    	$cancel_button->setAttribs(array(
    		'dojoType'	=>	'dijit.form.Button',
    		'label'		=>	'ยกเลิก',
    		'type'		=>	'button',
    		'id'		=>	'cancel',
    	));
    	
    	$urlParams = array(
    			'name'	=>	$editor_name,
    			'item'	=>	$itemid);
    	
    	$form_decorators = array(
    			array('ViewScript',array('viewScript'=>'forms/ajax_editor.phtml')),
    	);
    	$form	->setMethod('post')
    			->setName('editor_form')
    			->setAction($this->_helper->url('edit','product','admin',$urlParams))
    			->setDecorators($form_decorators)
    			->populate($product)
    			->addElement($product_form->getElement('send')->setAttrib('label','บันทึก'))
    			->addElement($cancel_button);
    	$this->view->form = $form;
    }

    public function editAction()
    {
        $itemid = $this->getRequest()->getParam('item');
    	$editor_name = $this->getRequest()->getParam('name');

    	$form = new Application_Form_Product();
    	if($this->getRequest()->isPost()){
    		if($form->isValidPartial($this->getRequest()->getPost())){
    			//valid data
    			$product = $this->product_model->findOneById($itemid);
		        if (false === $product){
		    		$result = array('code'=>-1,'message'=>'ไม่พบสินค้า');
		    	} else {
		    	    if ($editor_name == 'thumbnail') {  
		    	        
		    	        $thumbnail = $form->getElement('thumbnail');
		    	        //Create thumbnails
		    	        if($thumbnail->isUploaded()) {
		    	            $configs = $this->getInvokeArg('bootstrap')->getOption('files');
		    	        	$basePath = $configs['image_upload_path'] . '/products/' . $product->id . '/thumbnail';
		    	        	$fileInfo = $thumbnail->getFileInfo();
		    	        	$this->_helper->image->createThumbnail($basePath,$fileInfo,$this->getThumbnailDimensions());
		    	        }
		    	        //Create response message
		    	        $thumbHelper = $this->view->getHelper('thumbnail');
		    	        $thumbUrl = $thumbHelper->url(array(
		    	        		'group'	=>	'products',
		    	        		'iid'	=>	$product->id,
		    	        		'size'	=>	'small',
		    	        ));
		    	        //Force to refresh thumbnail on browser
		    	        if($thumbnail->isUploaded()) {
		    	            $thumbUrl .= '?' . time();
		    	        }
		    	        $message = ( ($thumbHelper->isExist($thumbUrl))?'<img src="'. $thumbUrl . '" style="margin-top:10px;">':'<span class="noData">ไม่มีรูป</span>' );
		    	        
		    	    } else {
		    	        switch($editor_name){
		    	        	case 'name':
		    	        		$product->name = $form->getValue('name');
		    	        		$message = $product->name;
		    	        		break;
		    	        	case 'category':
		    	        		$product->category_id = $form->getValue('category_id');
		    	        		$message = $product->category->name;
		    	        		break;
		    	        	case 'description':
		    	        		$product->description = $form->getValue('description');
		    	        		$message = 'ไม่แสดง';
		    	        		break;
		    	        	case 'price':
		    	        		$product->price = $form->getValue('normal_price');
		    	        		$product->sale_price = $form->getValue('sale_price');
		    	        		$message = $this->view->currency($product->price,Zend_Registry::get('Zend_Currency'));
		    	        		break;
		    	        }
		    	        //save record
		    	        $product->save();
		    	    }
		    	}
		    	$result = array('code'=>0,'message'=>$message);
		    } else {
		    	//invalid data
		        $result = array('code'=>-1,'message'=>'ข้อมูลไม่ถูกต้อง');
		    }
    	} else {
    		throw new Zend_Controller_Action_Exception('Submission is not posted.', 404);
    	}
    	//disbale layout
    	$this->_helper->layout()->disableLayout();

    	$this->view->json = Zend_Json_Encoder::encode($result);
    }

    public function searchAction()
    {
    	$formSearch = new Application_Form_ProductSearchWithFilter();
        $formSearch->setAction('/admin/product/search');
        $input = $this->getRequest()->getParams();
        //filtered input
        $formSearch->isValid($input);
        $keyword = $formSearch->getValue('keyword');
        $category = $formSearch->getValue('category');
        
        $q = $this->product_model->createQuery('p');
        
    	//if($this->getRequest()->isGet()){
    		
    		//add validators
    		$notEmpty = new Zend_Validate_NotEmpty();
    		//create query
    		
			//Filter-based Search Engine
    		if($notEmpty->isValid($keyword)){
	    		switch ($input['by']){
	    			case 'id':
	    				$q->addWhere('p.id = ?', $keyword);
	    				break;
	    			case 'name':
	    				$q->addWhere('p.name LIKE ?','%' . $keyword . '%');
	    				break;
	    			
	    		}
    		}
    		
    		if($notEmpty->isValid($category)){
    			$q->addWhere('p.category_id = ?',$category);
    		}
    		
    	//}
    	
    	$formSearch->populate($input);
    	$this->view->formSearch = $formSearch;
    	
        $products = $q->execute(array(),Doctrine_Core::HYDRATE_RECORD);
		$this->view->products = $products;
		$this->_helper->viewRenderer('index');
    }
    
    public function deleteAction()
    {
        $this->_helper->layout()->disableLayout();
        
    	if ($this->getRequest()->isPost()) {
    		$input = $this->getRequest()->getPost();
    		$id = $input['item'];
    		
    		if (!empty($id)) {
    			$product = $this->product_model->findOneById($id);
    			if ($product) {
    				$product->destroy();
    				$result = array('code'=>0);
    			} else {
    				$result = array('code'=>-1,'message'=>'ไม่พบรายการ');
    			}
    		}
    	} else {
    	    throw new Zend_Controller_Action_Exception('Must use POST method.');
    	}

    	$this->view->json = Zend_Json_Encoder::encode($result);
    }
    
}











