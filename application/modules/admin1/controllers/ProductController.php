<?php
class Admin_ProductController extends Zend_Controller_Action
{
    private $_productModel;
    
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
        $this->_productModel = new Model_Product();
        
        //dojo widget dialog theme
        $this->view->getHelper('headLink')->appendStylesheet('/js/libs/dojo/1.7.1/dojox/widget/Dialog/Dialog.css');

        $this->view->navtitle = 'จัดการสินค้า';
        //Create left menu
        $config = new Zend_Config_Xml(APPLICATION_PATH . '/modules/admin/configs/' . Zend_Controller_Front::getInstance()->getRequest()->getControllerName() . '_leftnav.xml','navigation');
        $container = new Zend_Navigation($config);
        $this->view->navigation($container);
        //set active nav
        $uri = $this->_request->getPathInfo();
        $activeNav = $this->view->navigation()->findByUri($uri);
        $activeNav->active = true;
        
		$this->_helper->ajaxContext
			->addActionContext('view', 'html')
			->addActionContext('editor', 'html')
			->addActionContext('edit', 'json')
			->addActionContext('delete', 'json')
			->initContext();
    }

    public function indexAction()
    {
    	$this->view->products = $this->_productModel->findAll();
    	
    	$formSearch = new Application_Form_ProductSearchWithFilter();
    	$this->view->searchForm = $formSearch;
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
				$this->_helper->redirector('search',null,null,array('keyword'=>$product->id,'by'=>'id'));
				exit();
			}
		}

		$this->view->form = $form;
    }

    public function viewAction()
    {
        $itemId = $this->getRequest()->getParam('item');
    	$product = $this->_productModel->findOneById($itemId);
    	
    	if (!empty($product)) {
    		$this->view->product = $product;
    	} else {
    		throw new Zend_Controller_Action_Exception('Invalid Product',404);
    	}
    }

    public function editorAction()
    {
	 	$input = $this->getRequest()->getParams();
	  	$itemId = $input['item'];
	 	$editorName = $input['editor'];
	    	
	   	$product = $this->_productModel->findOneById($itemId);
	  	if (!empty($product)) {
	        //create editor form
	        $productForm = new Application_Form_Product();
	        $form = new Application_Form_Editor();
	        $editorSubForm = $form->editorSubForm;
	    	switch($editorName){
	    		case 'name':
	    			$editorSubForm	->addElement($productForm->getElement('name'));
		        	break;
	    		case 'description':
	    			$editorSubForm	->addElement($productForm->getElement('description'));
	    			break;
	    		case 'thumbnail':
	    			$editorSubForm	->addElement($productForm->getElement('thumbnail'));
	    			break;
	    		case 'price':
	    			$editorSubForm	->addElement($productForm->getElement('normal_price'))
	    					->addElement($productForm->getElement('sale_price'));
	    			break;
	    		case 'category':
	    			$editorSubForm	->addElement($productForm->getElement('category_id'));
	    			break;
	    		default:
	    			throw new Zend_Controller_Action_Exception('Invalid Editor',404);
	    	}
	    	
	    	$form->populate($product->toArray());
	    	$this->view->editorForm = $form;
	    } else {
	    	throw new Zend_Controller_Action_Exception('Invalid Product',404);
	    }
    }

    public function editAction()
    {
        $productForm = new Application_Form_Product();
        $form = new Zend_Form();
        $form->addSubForm($productForm, 'editorSubForm');
        
    	if($this->getRequest()->isPost()){
    	    $input = $this->getRequest()->getPost();
    		//form validation
    	    $subForm = $form->editorSubForm;
    	    if($form->isValidPartial($input)){
    	        $itemId = $input['item'];
    	        $editorName = $input['editor'];
    			$product = $this->_productModel->findOneById($itemId);
		        if (!empty($product)){
		    	    if ($editorName == 'thumbnail') {  
		    	        $thumbnail = $subForm->getElement('thumbnail');
		    	        //Create thumbnails
		    	        if($thumbnail->isUploaded()) {
		    	            $configs = $this->getInvokeArg('bootstrap')->getOption('files');
		    	        	$basePath = $configs['image_upload_path'] . '/products/' . $product->id . '/thumbnail';
		    	        	$fileInfo = $thumbnail->getFileInfo();
		    	        	$this->_helper->image->createThumbnail($basePath,$fileInfo,$this->getThumbnailDimensions());
		    	        }

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

		    	        $message = ( ($thumbHelper->isExist($thumbUrl))?'<img src="'. $thumbUrl . '" style="margin-top:10px;">':'<span class="grayOut">ไม่ระบุ</span>' );
		    	        $this->view->json = Zend_Json_Encoder::encode(array('code'=>0,'message'=>$message));
		    	        $this->_helper->layout()->disableLayout();
		    	        return;
		    	        
		    	    } else {
		    	        switch($editorName){
		    	        	case 'name':
		    	        		$product->name = $subForm->getValue('name');
		    	        		$message = $product->name;
		    	        		break;
		    	        	case 'category':
		    	        		$product->category_id = $subForm->getValue('category_id');
		    	        		$message = $product->categoryName;
		    	        		break;
		    	        	case 'description':
		    	        		$product->description = $subForm->getValue('description');
		    	        		$message = $product->description;
		    	        		break;
		    	        	case 'price':
		    	        		$product->normal_price = $subForm->getValue('normal_price');
		    	        		$product->sale_price = $subForm->getValue('sale_price');
		    	        		$message = Zend_Registry::get('Zend_Currency')->toCurrency($product->price);
		    	        		break;
		    	        }
		    	        //save record
		    	        $product->save();
		    	    }
		    	    $this->view->code = 0;
		    	    $this->view->message = $message;
		    	} else {
		    	    throw new Zend_Controller_Action_Exception('Invalid Product', 404);
		    	}
    		} else {
		    	$this->view->code = -1;
		    	$this->view->message = 'ข้อมูลไม่ถูกต้อง';
		    }
    	} else {
    		throw new Zend_Controller_Action_Exception('Require Post', 404);
    	}
    }

    public function searchAction()
    {
    	$form = new Application_Form_ProductSearchWithFilter();
        $input = $this->getRequest()->getParams();
        
        $keyword = $input['keyword'];
        $by = $input['searchBy'];
        
        $q = $this->_productModel->createQuery('p');
    		
		//Filter-based Search Engine
        if(!empty($keyword)){
	    	switch ($by){
	    		case 'id':
	    			$q->addWhere('p.id = ?', $keyword);
	    			break;
	    		case 'name':
	    			$q->addWhere('p.name LIKE ?','%' . $keyword . '%');
	    			break;
	    	}
    	}
    		
    	$category = $input['filter']['category'];
    	if(!empty($category)){
    		$q->addWhere('p.category_id = ?',$category);
    	}
    	
    	$form->populate($input);
    	
		$this->view->products = $q->execute();
		$this->view->searchForm = $form;
		$this->render('index');
    }
    
    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
        	$input = $this->getRequest()->getPost();
        	$itemId = $input['item'];
        
        	if (!empty($itemId)) {
        		$product = $this->_productModel->findOneById($itemId);
        		if (!empty($product)) {
        			$product->delete();
        			$this->view->code = 0;
        			$this->view->message = "สินค้ารหัส $itemId ถูกลบแล้ว";
        		} else {
        			$this->view->code = -1;
        			$this->view->message = 'ไม่พบสินค้า';
        		}
        	} else {
        		throw new Zend_Controller_Action_Exception('Require Product ID',404);
        	}
        } else {
        	throw new Zend_Controller_Action_Exception('Require Post',404);
        }
    }
    
}











