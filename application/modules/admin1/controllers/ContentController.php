<?php
class Admin_ContentController extends Zend_Controller_Action
{

    private $_contentModel = null;

//     private function getThumbnailDimensions()
//     {
//     	$dim = array();
//     	$dim['small']['width'] = 125;
//     	$dim['small']['height'] = 89;
    
//     	$dim['medium']['width'] = 250;
//     	$dim['medium']['height'] = 178;
    
//     	$dim['big']['width'] = 375;
//     	$dim['big']['height'] = 267;
    
//     	return $dim;
//     }

    public function init()
    {
        $this->_contentModel = new Model_Content();
        
        //dojo widget dialog theme
        $this->view->getHelper('headLink')
        	->appendStylesheet('/js/libs/dojo/1.7.1/dojox/widget/Dialog/Dialog.css')
        	->appendStylesheet('/css/admin_content.css');
        $this->view->getHelper('headScript')->appendFile('/fckeditor/fckeditor.js');

        $this->view->navtitle = 'จัดการเนื้อหา';
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
//         $contents = $this->_contentModel->findAll();
//     	$this->view->contents = $contents;
    	
//     	$formSearch = new Application_Form_ContentSearchWithFilter();
//     	$this->view->searchForm = $formSearch;
    }

    public function addAction()
    {
        //Step1: Adding content header
        $form = new Application_Form_Content();

		if($this->getRequest()->isPost()){

			if($form->isValid($this->getRequest()->getPost())) {
				$content 			= 	new Model_Content();
				$content->name 		=	$form->getValue('name');
				$content->description 	=	$form->getValue('description');
				$content->category_id	=	$form->getValue('category_id');
				$content->created_date	=	date('Y-m-d H:i:s');
				//TODO: Get current userid
				$content->created_by_id		=	1;
				$content->rowid	=	$this->view->guid('N');
				$content->save();
				
				//create thumbnails
				$thumbnail = $form->getElement('thumbnail');
				if($thumbnail->isUploaded()){
				    $basePath = APPLICATION_PATH . '/../public/uploads/contents/' . $content->id . '/thumbnail';
				    $fileInfo = $thumbnail->getFileInfo();
				    $this->_helper->image->createThumbnail($basePath,$fileInfo,$this->getThumbnailDimensions());
				}
				
				//redirect to next steps
				$this->_helper->redirector('add1',null,null,array('item'=>$content->id));
				return;
			}
			
		}

		$form->setAction($this->_helper->url('add','content','admin'));
		$this->view->form = $form;
    }

    public function add1Action()
    {
        //Step2: Adding content
        $itemId = $this->getRequest()->getParam('item');
        $content = $this->_contentModel->findOneById($itemId);
        
        $form = new Application_Form_Content1();
        
        if($this->getRequest()->isPost()){

        	if($form->isValid($this->getRequest()->getPost())) {
        		$content->body 	=	$form->getValue('body');
        		$content->is_published = $form->getValue('is_published');
        		$content->save();
        		$this->_helper->redirector('index');
        		return;
        	}
        	
        }

        $form->populate($content->toArray(false));
        $this->view->content = $content;
        $form->setAction($this->_helper->url('add1','content','admin',$this->getDataParams($this->getRequest()->getParams())));
        $this->view->form = $form;
    }

    private function getDataParams($params)
    {
	    $dataParams = array();
	    $exclude = array('module','controller','action');
	    foreach ($params as $key=>$value) {
	        if (!in_array($key, $exclude)) {
	            $dataParams[$key] = $value;
	        } 
	    }
	    return $dataParams;
    }

    public function searchAction()
    {
//         $form = new Application_Form_ContentSearchWithFilter();
//         $input = $this->getRequest()->getParams();
        
//         $keyword = $input['keyword'];
//         $by = $input['searchBy'];
        
//         $q = $this->_contentModel->createQuery('c');

// 		//Filter-based Search Engine
//         if(!empty($keyword)){
// 	    	switch ($by){
// 	    		case 'id':
// 	    			$q->addWhere('c.id = ?', $keyword);
// 	    			break;
// 	    		case 'name':
// 	    			$q->addWhere('c.name LIKE ?','%' . $keyword . '%');
// 	    			break;
// 	    	}
//     	}

//     	$category = $input['filter']['category'];
//     	if(!empty($category)){
//     		$q->addWhere('c.category_id = ?',$category);
//     	}
    	
//     	$form->populate($input);
    	
// 		$this->view->contents = $q->execute();
// 		$this->view->searchForm = $form;
// 		$this->render('index');
    }

    public function deleteAction()
    {
    	if ($this->getRequest()->isPost()) {
        	$input = $this->getRequest()->getPost();
        	$itemId = $input['item'];
        
        	if (!empty($itemId)) {
        		$content = $this->_contentModel->findOneById($itemId);
        		if (!empty($content)) {
        			$content->delete();
        			$this->view->code = 0;
        			$this->view->message = "เนื้อหารหัส $itemId ถูกลบแล้ว";
        		} else {
        			$this->view->code = -1;
        			$this->view->message = 'ไม่พบสินค้า';
        		}
        	} else {
        		throw new Zend_Controller_Action_Exception('Require Content ID',404);
        	}
        } else {
        	throw new Zend_Controller_Action_Exception('Require Post',404);
        }
    }

    public function viewAction()
    {
   	 	$itemId = $this->getRequest()->getParam('item');
    	$content = $this->_contentModel->findOneById($itemId);

    	if (!empty($content)) {
    		$this->view->content = $content;
    	} else {
    		throw new Zend_Controller_Action_Exception('Invalid Content',404);
    	}
    }

    public function editorAction()
    {
	  	$input = $this->getRequest()->getParams();
	  	$itemId = $input['item'];
	 	$editorName = $input['editor'];
	    	
	  	$content = $this->_contentModel->findOneById($itemId);
		if (!empty($content)) {
	        //create editor form
	        $contentElements = array('name','thumbnail','category');
	        $contentForm = $this->getFormByEditor($editorName);
	        $form = new Application_Form_Editor();
	        $editorSubForm = $form->editorSubForm;
	    	switch($editorName){
	    		case 'name':
	    			$editorSubForm	->addElement($contentForm->getElement('name'));
		        	break;
	    		case 'thumbnail':
	    			$editorSubForm	->addElement($contentForm->getElement('thumbnail'));
	    			break;
	    		case 'category':
	    			$editorSubForm	->addElement($contentForm->getElement('category_id'));
	    			break;
	    		case 'body':
	    		    $editorSubForm	->addElement($contentForm->getElement('body')->removeDecorator('label'));
	    		    break;
	    		default:
	    		    throw new Zend_Controller_Action_Exception('Invalid Editor',404);
	    	}
	    	
	    	$form->populate($content->toArray());
	    	$this->view->editorForm = $form;
		} else {
		    throw new Zend_Controller_Action_Exception('Invalid Content',404);
		}
    }

    public function editAction()
    {
    	if($this->getRequest()->isPost()){
    	    $input = $this->getRequest()->getPost();
    	    $params = $this->getRequest()->getParams();
    	    $itemId = $params['item'];
    	    $editorName = $params['editor'];
    		//form validation
    	    $contentForm = $contentForm = $this->getFormByEditor($editorName);
    	    $form = new Zend_Form();
    	    $form->addSubForm($contentForm, 'editorSubForm');
    	    $subForm = $form->editorSubForm;

    	    if($form->isValidPartial($input)){
    			$content = $this->_contentModel->findOneById($itemId);
		        if (!empty($content)){
		    	    if ($editorName == 'thumbnail') {  
		    	        $thumbnail = $subForm->getElement('thumbnail');
		    	        //Create thumbnails
		    	        if($thumbnail->isUploaded()) {
		    	            $configs = $this->getInvokeArg('bootstrap')->getOption('files');
		    	        	$basePath = $configs['image_upload_path'] . '/contents/' . $content->id . '/thumbnail';
		    	        	$fileInfo = $thumbnail->getFileInfo();
		    	        	$this->_helper->image->createThumbnail($basePath,$fileInfo,$this->getThumbnailDimensions());
		    	        }

		    	        $thumbHelper = $this->view->getHelper('thumbnail');
		    	        $thumbUrl = $thumbHelper->url(array(
		    	        		'group'	=>	'contents',
		    	        		'iid'	=>	$content->id,
		    	        		'size'	=>	'small',
		    	        ));
		    	        //Force to refresh thumbnail on browser
		    	        if($thumbnail->isUploaded()) {
		    	            $thumbUrl .= '?' . time();
		    	        }
		    	        //set response for dojo.iframe.send
		    	        $message = ( ($thumbHelper->isExist($thumbUrl))?'<img src="'. $thumbUrl . '" style="margin-top:10px;">':'<span class="grayOut">ไม่ระบุ</span>' );
		    	        $this->view->json = Zend_Json_Encoder::encode(array('code'=>0,'message'=>$message));
		    	        $this->_helper->layout()->disableLayout();
		    	        $this->renderScript('ajax-iframe');
		    	        return;
		    	    } else {
		    	        switch($editorName){
		    	        	case 'name':
		    	        		$content->name = $subForm->getValue('name');
		    	        		$message = $content->name;
		    	        		break;
		    	        	case 'category':
		    	        		$content->category_id = $subForm->getValue('category_id');
		    	        		$message = $content->category->name;
		    	        		break;
		    	        	case 'body':
		    	        	    $content->body = $subForm->getValue('body');
		    	        	    $message = 'บันทึกข้อมูลเสร็จเรียบร้อย';
		    	        	    break;
		    	        	default:
		    	        	    throw new Zend_Controller_Action_Exception('Invalid Editor',404);
		    	        }
		    	        //save record
		    	        $content->save();
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
    
    private function getFormByEditor($editorName)
    {
        $contentElements = array('name','thumbnail','category');
        $content1Elements = array('body');
        if (in_array($editorName, $contentElements)) {
        	return new Application_Form_Content();
        } elseif (in_array($editorName, $content1Elements)) {
        	return new Application_Form_Content1();
        }
    }


}

















