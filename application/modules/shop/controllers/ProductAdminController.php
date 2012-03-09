<?php
require_once('BaseController.php');
class Shop_ProductAdminController extends Shop_BaseController
{

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
        $this->_helper->authen->protect();
        parent::init();

        $this->view->headScript()->appendFile('/ckeditor/ckeditor.js');
        //left-menu navigation
        $front = Zend_Controller_Front::getInstance();
        $this->view->navtitle = 'จัดการสินค้า';
        $config = new Zend_Config_Xml($front->getModuleDirectory() . '/configs/product-admin-menu.xml','navigation');
        $container = new Zend_Navigation($config);
        $this->view->navigation($container);
        
        $uri = $this->_request->getPathInfo();
        $activeNav = $this->view->navigation()->findByUri($uri);
        $activeNav->active = true;
        
        $this->_helper->ajaxContext
        ->addActionContext('view', 'html')
        ->addActionContext('ajax-form', 'html')
        ->addActionContext('edit', 'json')
        ->addActionContext('delete', 'json')
        ->initContext();
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $params = $request->getParams();
        $keyword = $params['keyword'];
        $by = $params['searchBy'];
        
        //filter
        $q = $this->_productModel->createQuery('p');
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
	    	
	    $category = $params['category'];
	    if(!empty($category)){
	    	$q->addWhere('p.category_id = ?',$category);
	    }
        
        $this->view->products = $q->execute();
        
    	$formSearch = new Shop_Form_ProductSearchWithFilter();
		$formSearch->setAction($this->_helper->url('index'));
    	$formSearch->populate($params);
    	
    	$this->view->searchForm = $formSearch;
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form = new Shop_Form_Product();
        $form->removeElement('content');
        $form->removeElement('is_released');

		if($request->isPost()){
			$input = $request->getPost();
			if ($form->isValid($input)) {

			    //save record
			    $thumbnail = $form->getElement('thumbnail');
			    $form->removeElement('thumbnail');
				$product 	= 	new Model_Product();
				$product->setArray($form->getValidValues($input));
				
				$product->created_date = date('Y-m-d H:i:s');
				$product->rowid	=	$this->view->guid('N');
				$product->save();

				//create thumbnails
				if($thumbnail->isUploaded()){
					$configs = $this->getInvokeArg('bootstrap')->getOption('files');
					$basePath = $configs['image_upload_path'] . '/products/' . $product->rowid . '/thumbnail';
					$fileInfo = $thumbnail->getFileInfo();
					$this->_helper->image->createThumbnail($basePath,$fileInfo,$this->getThumbnailDimensions());
				}
				
				//redirect to next steps
				$this->_helper->redirector('add1',null,null,array('id'=>intval($product->id)));
			}
		}

		$form->setName('newProductForm');
		$form->send->setName('addNewProduct')->setAttrib('label','เพิ่มสินค้าใหม่');
		$this->view->newProductForm = $form;
    }

    public function add1Action()
    {
        $request = $this->getRequest();
        $params = $request->getParams();
        $input = $request->getPost();
        $producteId = $params['id'];
        $product = $this->_productModel->findOneById($producteId);
        
        $form = new Shop_Form_Product();
        $newFormElements = array();
        $newFormElements[] = $form->content;
        $newFormElements[] = $form->is_released;
        $newFormElements[] = $form->send->setAttrib('label','บันทึกข้อมูล');
        $form->clearElements()->addElements($newFormElements);
        
        if($this->getRequest()->isPost()){

        	if($form->isValid($input)) {
        	    $product->setArray($form->getValidValues($input));
        		$product->save();
        		//redirect
        		$this->_helper->redirector('index',null,null,array('keyword'=>intval($product->id),'searchBy'=>'id'));
        		return;
        	}
        	
        }

        $form->setName('newProductForm2');
        $form->populate($product->toArray());
        $form->send->setName('addNewProduct2');
        $this->view->product = $product;
        $this->view->newProductForm2 = $form;
    }

    public function viewAction()
    {
        $request = $this->getRequest();
        $params = $request->getParams();
    	$productId = $params['id'];

    	$product = $this->_productModel->findOneById($productId);

    	if (empty($product)) {
    	    throw new Zend_Controller_Action_Exception('Invalid Product');
    	}
    	
    	$this->view->product = $product;
    }

    public function ajaxFormAction()
    {
        $request = $this->getRequest();
    	$params = $request->getParams();
	   	$productId = $params['id'];
	   	$formName = $params['name'];
	    
	 	$product = $this->_productModel->findOneById($productId);
	 	if (empty($product)) { throw new Zend_Controller_Action_Exception('Invalid Product'); }

		//create form
	 	$editor = new Application_Form_Editor();
		$productForm = new Shop_Form_Product();
		$productForm->populate($product->toArray());

    	switch($formName){
    		case 'name':
    			$editor	->addElement($productForm->name);
	        	break;
    		case 'thumbnail':
    			$editor	->addElement($productForm->thumbnail);
    			break;
    		case 'category':
    			$editor	->addElement($productForm->category_id);
    			break;
    		case 'description':
    			$editor	->addElement($productForm->description);
    			break;
    		case 'price':
    			$editor	->addElement($productForm->normal_price)
    					->addElement($productForm->sale_price);
    			break;
    		case 'content':
    		    $editor	->addElement($productForm->content->removeDecorator('label'));
    		    break;
    		case 'release':
    		    $editor->addElement($productForm->is_released);
    		    break;
    		default:
    		    throw new Zend_Controller_Action_Exception('Invalid Form');
	 	}
	    	
	 	$editor->setAction($this->_helper->url('edit',null,null,array('name'=>$formName,'id'=>$productId,'format'=>'json')));
	    $editor->addSubmitButton();

	    $this->view->form = $editor;
    }

    public function editAction()
    {
    	$request = $this->getRequest();
    	if($request->isPost()){
    	    
    	    $params = $request->getParams();
    	    $input = $request->getPost();
    	    $productId = $params['id'];
    	    $formName = $params['name'];

    	    $productForm = new Shop_Form_Product();
    	    if($productForm->isValidPartial($input)){
    			$product = $this->_productModel->findOneById($productId);
    			if (empty($product)) { throw new Zend_Controller_Action_Exception('Invalid Product'); }
    			
    			if ($formName == 'thumbnail') {  
		    		$thumbnail = $productForm->thumbnail;
		    		//Create thumbnails
		    		if($thumbnail->isUploaded()) {
		    	    	$configs = $this->getInvokeArg('bootstrap')->getOption('files');
		    	       	$basePath = $configs['image_upload_path'] . '/products/' . $product->rowid . '/thumbnail';
		    	       	$fileInfo = $thumbnail->getFileInfo();
		    	      	$this->_helper->image->createThumbnail($basePath,$fileInfo,$this->getThumbnailDimensions());
		    	   	}

		    	  	$thumbHelper = $this->view->getHelper('thumbnail');
		    	 	$thumbUrl = $thumbHelper->url(array(
		    	        		'group'	=>	'products',
		    	        		'id'	=>	$product->rowid,
		    	        		'size'	=>	'small',
		    	  	));
		    	 	//Force browser to refresh thumbnail
		    	 	if($thumbnail->isUploaded()) {
		    	     	$thumbUrl .= '?' . time();
		    	  	}
		    	  	//set response for dojo.iframe.send
		    	   	$message = ( ($thumbHelper->isExist($thumbUrl))?'<img src="'. $thumbUrl . '" style="margin-top:10px;">':'<span class="grayOut">ไม่ระบุ</span>' );
		    	   	$this->view->json = Zend_Json_Encoder::encode(array('code'=>0,'message'=>$message));
		    	   	$this->_helper->layout()->disableLayout();
		    	   	$this->renderScript('ajax-iframe.phtml');
		    	 	return;
    			} else {
		    	    
	    			$product->setArray($productForm->getValidValues($input));
	    			//set response
	    	    	switch($formName){
			    		case 'name':
			    	     	$message = $product->name;
			    	    	break;
			    		case 'category':
			    	      	$message = $product->category->name;
			    	      	break;
			    	 	case 'content':
			    	      	$message = 'บันทึกข้อมูลเสร็จเรียบร้อย';
			    	      	break;
			    	  	case 'description':
			    	      	$message = $product->description;
			    	      	break;
			    	 	case 'price':
			    	      	$message = Zend_Registry::get('Zend_Currency')->toCurrency($product->price);;
			    	      	break;
			    	 	case 'release':
			    	 	    $message = $product->release;
			    	 	    break;
			    	   	default:
			    	      	throw new Zend_Controller_Action_Exception('Invalid Form');
			    	}
				 	//save record
				 	$product->save();
				    	    
				  	$this->view->code = 0;
				 	$this->view->message = $message;
		    	}
		    } else {
		    	$this->view->code = -1;
		    	$this->view->message = 'ไม่สามารถบันทึกได้ - ข้อมูลไม่ถูกต้อง';
		    }
    	} else {
    		throw new Zend_Controller_Action_Exception('Require Post');
    	}
    }

    public function deleteAction()
    {
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$input = $request->getPost();
    		$params = $request->getParams();
    		$productId = $params['id'];
    		
    		if (empty($productId)) {
    		    throw new Zend_Controller_Action_Exception('Invalid Product ID');
    		}

    		$product = $this->_articleModel->findOneById($productId);
    		if (!empty($product)) {
    			$product->delete();
    			$this->view->code = 0;
    			$this->view->message = "สินค้ารหัส $productId ถูกลบแล้ว";
    		} else {
    		    $this->view->code = -1;
    			$this->view->message = 'ไม่พบรายการผู้ใช้นี้';
    		}
    		
    	} else {
    	    throw new Zend_Controller_Action_Exception('Require Post');
    	}
    }


}













