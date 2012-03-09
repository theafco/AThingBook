<?php
require_once('BaseController.php');
class Content_ArticleAdminController extends Content_BaseController
{

    private function getThumbnailDimensions()
    {
    	$dim = array();
    	$dim['small']['width'] = 125;
    	$dim['small']['height'] = 89;
    
    	$dim['medium']['width'] = 250;
    	$dim['medium']['height'] = 178;
    
    	$dim['big']['width'] = 375;
    	$dim['big']['height'] = 267;
    
    	return $dim;
    }

    public function init()
    {
        $this->_helper->authen->protect();
        parent::init();

        $this->view->headScript()->appendFile('/ckeditor/ckeditor.js');

        //left-menu navigation
        $front = Zend_Controller_Front::getInstance();
        $this->view->navtitle = 'จัดการเนื้อหา';
        $config = new Zend_Config_Xml($front->getModuleDirectory() . '/configs/article-admin-menu.xml','navigation');
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
    	$q = $this->_articleModel->createQuery('a');
    	if(!empty($keyword)){
	    	switch ($by){
	    		case 'id':
	    			$q->addWhere('a.id = ?', $keyword);
	    			break;
	    		case 'name':
	    			$q->addWhere('a.name LIKE ?','%' . $keyword . '%');
	    			break;
	    	}
    	}

    	$category = $params['category'];
    	if(!empty($category)){
    		$q->addWhere('a.category_id = ?',$category);
    	}
        
        $this->view->articles = $q->execute();
        
    	$formSearch = new Content_Form_ArticleSearchWithFilter();
		$formSearch->setAction($this->_helper->url('index'));
    	$formSearch->populate($params);
    	
    	$this->view->searchForm = $formSearch;
    }

    public function viewAction()
    {
        $request = $this->getRequest();
        $params = $request->getParams();
    	$articleId = $params['id'];

    	$article = $this->_articleModel->findOneById($articleId);

    	if (empty($article)) {
    	    throw new Zend_Controller_Action_Exception('Invalid Article');
    	}
    	
    	$this->view->article = $article;
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form = new Content_Form_Article();
        $form->removeElement('body');
        $form->removeElement('is_published');
        
		if($request->isPost()){
			$input = $request->getPost();
			if ($form->isValid($input)) {

			    $thumbnail = $form->getElement('thumbnail');
			    $form->removeElement('thumbnail');
			    //save record
				$article 	= 	new Model_Article();
				$article->setArray($form->getValidValues($input));
				$article->createdBy = $this->_helper->authen->getUser();
				$article->created_date = date('Y-m-d H:i:s');
				$article->rowid	=	$this->view->guid('N');
				$article->save();

				//create thumbnails
				if($thumbnail->isUploaded()){
					$configs = $this->getInvokeArg('bootstrap')->getOption('files');
					$basePath = $configs['image_upload_path'] . '/contents/' . $article->rowid . '/thumbnail';
					$fileInfo = $thumbnail->getFileInfo();
					$this->_helper->image->createThumbnail($basePath,$fileInfo,$this->getThumbnailDimensions());
				}
				
				//redirect to next steps
				$this->_helper->redirector('add1',null,null,array('id'=>$article->id));
			}
		}

		$form->setName('newArticleForm');
		$form->send->setName('addNewArticle')->setAttrib('label','เพิ่มบทความใหม่');
		$this->view->newArticleForm = $form;
    }

    public function add1Action()
    {
        $request = $this->getRequest();
        $params = $request->getParams();
        $input = $request->getPost();
        $articleId = $params['id'];
        $article = $this->_articleModel->findOneById($articleId);
        
        $form = new Content_Form_Article();
        $newFormElements = array();
        $newFormElements[] = $form->body;
        $newFormElements[] = $form->is_published;
        $newFormElements[] = $form->send->setAttrib('label','บันทึกข้อมูล');
        $form->clearElements()->addElements($newFormElements);
        
        if($this->getRequest()->isPost()){

        	if($form->isValid($input)) {
        	    $article->setArray($form->getValidValues($input));
        		$article->save();
        		//redirect
        		$this->_helper->redirector('index',null,null,array('keyword'=>(int)$article->id,'searchBy'=>'id'));
        		return;
        	}
        	
        }

        $form->setName('newArticleForm2');
        $form->populate($article->toArray());
        $form->send->setName('addNewArticle2');
        $this->view->article = $article;
        $this->view->newArticleForm2 = $form;
    }

    public function ajaxFormAction()
    {
        $request = $this->getRequest();
    	$params = $request->getParams();
	   	$articleId = $params['id'];
	   	$formName = $params['name'];
	    
	 	$article = $this->_articleModel->findOneById($articleId);
	 	if (empty($article)) { throw new Zend_Controller_Action_Exception('Invalid Article'); }

		//create form
		$articleForm = new Content_Form_Article();
		$articleForm->populate($article->toArray());
		$editor = new Application_Form_Editor();
		$editor->setAction($this->_helper->url('edit',null,null,array('name'=>$formName,'id'=>$articleId,'format'=>'json')));

    	switch($formName){
	    		case 'name':
	    			$editor	->addElement($articleForm->name);
		        	break;
	    		case 'thumbnail':
	    			$editor	->addElement($articleForm->thumbnail);
	    			break;
	    		case 'category':
	    			$editor	->addElement($articleForm->category_id);
	    			break;
	    		case 'body':
	    		    $editor	->addElement($articleForm->body->removeDecorator('label'));
	    		    break;
	    		case 'publish':
	    		    $editor->addElement($articleForm->is_published);
	    		    break;
	    		default:
	    		    throw new Zend_Controller_Action_Exception('Invalid Form');
	    	}
	    
	    $editor->addSubmitButton();

	    $this->view->form = $editor;
    }

    public function editAction()
    {
    	$request = $this->getRequest();
    	$articleForm = new Content_Form_Article();
    	
    	if($request->isPost()){
    	    
    	    $params = $request->getParams();
    	    $input = $request->getPost();
    	    $articleId = $params['id'];
    	    $formName = $params['name'];

    	    if($articleForm->isValidPartial($input)){
    			$article = $this->_articleModel->findOneById($articleId);
    			if (empty($article)) { throw new Zend_Controller_Action_Exception('Invalid Article'); }
    			
    			if ($formName == 'thumbnail') {  
		    		$thumbnail = $articleForm->thumbnail;
		    		//Create thumbnails
		    		if($thumbnail->isUploaded()) {
		    	    	$configs = $this->getInvokeArg('bootstrap')->getOption('files');
		    	       	$basePath = $configs['image_upload_path'] . '/contents/' . $article->rowid . '/thumbnail';
		    	       	$fileInfo = $thumbnail->getFileInfo();
		    	      	$this->_helper->image->createThumbnail($basePath,$fileInfo,$this->getThumbnailDimensions());
		    	   	}

		    	  	$thumbHelper = $this->view->getHelper('thumbnail');
		    	 	$thumbUrl = $thumbHelper->url(array(
		    	        		'group'	=>	'contents',
		    	        		'id'	=>	$article->rowid,
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

	    			$article->setArray($articleForm->getValidValues($input));
	    			//set response
	    	    	switch($formName){
			    		case 'name':
			    	     	$message = $article->name;
			    	    	break;
			    		case 'category':
			    	      	$message = $article->category->name;
			    	      	break;
			    	 	case 'body':
			    	      	$message = 'บันทึกข้อมูลเสร็จเรียบร้อย';
			    	      	break;
			    	 	case 'publish':
			    	 	    $message = $article->publish;
			    	 	    break;
			    	   	default:
			    	      	throw new Zend_Controller_Action_Exception('Invalid Form');
			    	}
				 	//save record
				 	$article->save();
				    	    
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
    		$articleId = $params['id'];
    		
    		if (empty($articleId)) {
    		    throw new Zend_Controller_Action_Exception('Invalid Article ID');
    		}

    		$article = $this->_articleModel->findOneById($articleId);
    		if (!empty($article)) {
    			$article->delete();
    			$this->view->code = 0;
    			$this->view->message = "บทความรหัส $articleId ถูกลบแล้ว";
    		} else {
    		    $this->view->code = -1;
    			$this->view->message = 'ไม่พบรายการผู้ใช้นี้';
    		}
    		
    	} else {
    	    throw new Zend_Controller_Action_Exception('Require Post');
    	}
    }


}













