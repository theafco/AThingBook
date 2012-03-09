<?php
require_once('BaseController.php');
class Shop_PromotionAdminController extends Shop_BaseController
{

    public function init()
    {
        $this->_helper->authen->protect();
        parent::init();
        
        $this->_helper->ajaxContext
	        ->addActionContext('view', 'html')
	        ->addActionContext('ajax-form', 'html')
	        ->addActionContext('edit', 'json')
	        ->addActionContext('delete', 'json')
	        ->initContext();
    }

    public function indexAction()
    {
        // action body
    }

    public function editAction()
    {
        $request = $this->getRequest();
    	if($request->isPost()){
    	    
    	    $params = $request->getParams();
    	    $input = $request->getPost();
    	    $promotionId = $params['id'];
    	    $formName = $params['name'];
    	    
    	    $promotionForm = new Shop_Form_ProductUnitPromotion();

    	    if($promotionForm->isValidPartial($input)){
    	        $promotion = $this->_productModel->findOneById($promotionId);
    	     	$promotion->setArray($promotionForm->getValidValues($input));
    	      	//save record
    	      	$promotion->save();
    	        //set response
    	        switch($formName){
    	        	case 'specialPrice':
    	        		$message = $promotion->toString();
    	        		break;
    	        	default:
    	        		throw new Zend_Controller_Action_Exception('Invalid Form');
    	        }

    	        $this->view->code = 0;
    	        $this->view->message = $message;
    	    } else {
		    	$this->view->code = -1;
		    	$this->view->message = 'ไม่สามารถบันทึกได้ - ข้อมูลไม่ถูกต้อง';
    	    }
    	} else {
    		throw new Zend_Controller_Action_Exception('Require Post');
    	}
    }

    public function ajaxFormAction()
    {
        $request = $this->getRequest();
    	$params = $request->getParams();
	   	$promotionId = $params['id'];
	   	$formName = $params['name'];
	   	$promotion = $this->_productUnitPromotion->findOneById($promotionId);
	   	if (empty($promotion)) { throw new Zend_Controller_Action_Exception('Invalid Promotion'); }
	   	
	   	switch ($formName) {
	   		case 'specialPrice':
	   	    	$editor = new Shop_Form_ProductUnitPromotion();
	   	    	if (!empty($promotion)) {
	   	    	    $editor->populate($promotion->toArray());
	   	    	}
	   	    	break;
	   		default:
	   		    throw new Zend_Controller_Action_Exception('Invalid Form');
	   	}
	   	
	   	$editor->setAction($this->_helper->url('edit',null,null,array('name'=>$formName,'id'=>$promotionId,'format'=>'json')));
	   	$editor->addSubmitButton();
	   	
	   	$this->view->form = $editor;
    }

    public function deleteAction()
    {
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$input = $request->getPost();
    		$params = $request->getParams();
    		$prodmotionId = $params['id'];
    		
    		if (empty($prodmotionId)) {
    		    throw new Zend_Controller_Action_Exception('Invalid Promotion ID');
    		}

    		$promotion = $this->_productUnitPromotion->findOneById($prodmotionId);
    		if (!empty($promotion)) {
    			$promotion->delete();
    			$this->view->code = 0;
    		} else {
    		    $this->view->code = -1;
    			$this->view->message = 'ไม่พบรายการโปรโมชั่นนี้';
    		}	
    	} else {
    	    throw new Zend_Controller_Action_Exception('Require Post');
    	}
    }


}







