<?php
class Admin_ContentController extends Zend_Controller_Action
{

    private $content_model = null;

    /***
     * Return content thumbnail dimensions
    *
    * @return Array
    */
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
        $this->content_model = new Model_Content();
        
        //Enable Dojo View Helper
        Zend_Dojo::enableView($this->view);
        
        //Create left menu
		$config = new Zend_Config_Xml(APPLICATION_PATH . '/modules/admin/configs/content_leftnav.xml','navigation');
		$container = new Zend_Navigation($config);
		$this->view->navigation($container);
		
		$uri = $this->_request->getPathInfo();
		$activeNav = $this->view->navigation()->findByUri($uri);
		$activeNav->active = true;
    }

    public function indexAction()
    {
        $contents = $this->content_model->findAll();
    	$this->view->contents = $contents;
    	
    	$formSearch = new Application_Form_ContentSearchWithFilter();
    	$formSearch->setAction('/admin/content/search');
    	$this->view->formSearch = $formSearch;
    }

    public function addAction()
    {
        //Step1: Adding content header
        $form = new Application_Form_Content();

		if($this->getRequest()->isPost()){

			if($form->isValid($this->getRequest()->getPost())) {
				$content 			= 	new Model_Content();
				$content->name 		=	$form->getValue('name');
				$content->format_id 	=	$form->getValue('format_id');
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
        $content = $this->content_model->findOneById($itemId);
        
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
        $formSearch = new Application_Form_ContentSearchWithFilter();
        $formSearch->setAction('/admin/content/search');
        $input = $this->getRequest()->getParams();
        
        //filtered input
        $formSearch->isValid($input);
        $keyword = $formSearch->getValue('keyword');
        $category = $formSearch->getValue('category');
        
        $q = $this->content_model->createQuery('c');
        
    	//if($this->getRequest()->isGet()){
    		
    		//add validators
    		$notEmpty = new Zend_Validate_NotEmpty();
    		//create query
    		
			//Filter-based Search Engine
    		if($notEmpty->isValid($keyword)){
	    		switch ($input['by']){
	    			case 'id':
	    				$q->addWhere('c.id = ?', $keyword);
	    				break;
	    			case 'name':
	    				$q->addWhere('c.name LIKE ?','%' . $keyword . '%');
	    				break;
	    		}
    		}
    		
    		if($notEmpty->isValid($category)){
    			$q->addWhere('c.category_id = ?',$category);
    		}
    		
    	//}
    	
    	$formSearch->populate($input);
    	$this->view->formSearch = $formSearch;
    	
        $contents = $q->execute(array(),Doctrine_Core::HYDRATE_RECORD);
		$this->view->contents = $contents;
		$this->_helper->viewRenderer('index');
    }

    public function deleteAction()
    {
        
        if ($this->getRequest()->isPost()) {
    		$input = $this->getRequest()->getPost();
    		$id = $input['item'];
    	}
    	
    	if (!empty($id)) {
    		$content = $this->content_model->findOneById($id);
    		if ($content) {
    			$content->delete();
    			$result = 0;
    		} else {
    			$result = 'ไม่พบรายการ';
    		}
    		$this->_response->appendBody($result);
    	}
    	
    	//disable renderer
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->layout()->disableLayout();
    }


}











