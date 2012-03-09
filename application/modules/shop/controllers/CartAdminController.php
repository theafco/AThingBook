<?php
require_once('BaseController.php');
class Shop_CartAdminController extends Shop_BaseController
{

    public function init()
    {
        $this->_helper->authen->protect();
        parent::init();
        
        //left-menu navigation
        $front = Zend_Controller_Front::getInstance();
        $this->view->navtitle = 'จัดการใบสั่งซื้อ';
        $config = new Zend_Config_Xml($front->getModuleDirectory() . '/configs/cart-admin-menu.xml','navigation');
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
        $q = $this->_purchaseOrderModel->createQuery('o');
	    if(!empty($keyword)){
		    switch ($by){
		    	case 'id':
		    		$q->addWhere('o.id = ?', $keyword);
		    		break;
		    }
	    }
	    	
	    $status = $params['status'];
	    if(!empty($status)){
	    	$q->addWhere('o.status_id = ?',$status);
	    }
        
        $this->view->orders = $q->execute();
        
    	$formSearch = new Shop_Form_PurchaseOrderSearchWithFilter();
		$formSearch->setAction($this->_helper->url('index'));
    	$formSearch->populate($params);
    	
    	$this->view->searchForm = $formSearch;
    }

    public function viewAction()
    {
        $request = $this->getRequest();
        $params = $request->getParams();
    	$orderId = $params['id'];

    	$order = $this->_purchaseOrderModel->findOneById($orderId);

    	if (empty($order)) {
    	    throw new Zend_Controller_Action_Exception('Invalid Purchase Order');
    	}
    	
    	$this->view->order = $order;
    }

    public function editAction()
    {
    	$request = $this->getRequest();
    	$userForm = new Auth_Form_User();
    	
    	if($request->isPost()){
    	    
    	    $params = $request->getParams();
    	    $input = $request->getPost();
    	    $userId = $params['id'];
    	    $formName = $params['name'];

    	    if($userForm->isValidPartial($input)){
    			$user = $this->_userModel->findOneById($userId);
    			if (empty($user)) { throw new Zend_Controller_Action_Exception('Invalid User'); }

    			//remove repassword field
    			if ($formName == 'password') {
    			   $userForm->removeElement('repassword');
    			}

    			$user->setArray($userForm->getValidValues($input));
    			//set response
			    	switch($formName) {
			    	    case 'name':
			    	    	$message = $user->name;
			    	    	break;
			    	    case 'alias':
			    	        $message = $user->alias;
			    	        break;
			    	    case 'gender':
			    	        $message = $user->genderText;
			    	    	break;
			    	    case 'birthday':
			    	    	$date = new Zend_Date();
			    	    	$message = $date->set($user->birthday)->get(Zend_Date::DATE_LONG);
			    	    	break;
			    	    case 'address':
			    	    	$message = $user->address;
			    	    	break;
			    	    case 'phone':
			    	        $message = $user->phone;
			    	        if (empty($message)) {
			    	            $message = '<span class="grayOut">ไม่ระบุ</span>';
			    	        }
			    	        break;
			    	    case 'email':
			    	    	$message = $user->email;
			    	    	break;
			    	    case 'password':
			    	    	$message = 'ข้อมูลลับ';
			    	    	break;
			    		case 'role':
			    			$message = $user->role->name;
			    		break;
			    	}
			 		//save record
			    	$user->save();
			    	    
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

    public function deleteAction()
    {
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$input = $request->getPost();
    		$params = $request->getParams();
    		$orderId = $params['id'];
    		
    		if (empty($orderId)) {
    		    throw new Zend_Controller_Action_Exception('Invalid Purchase Order ID');
    		}
			
    		$order = $this->_purchaseOrderModel->findOneById($orderId);
    		if (!empty($order)) {
    			$order->delete();
    			$this->view->code = 0;
    			$this->view->message = "ใบสั่งซื้อรหัส $orderId ถูกลบแล้ว";
    		} else {
    		    $this->view->code = -1;
    			$this->view->message = 'ไม่พบรายการใบสั่งซื้อนี้';
    		}
    		
    	} else {
    	    throw new Zend_Controller_Action_Exception('Require Post');
    	}
    }

    public function ajaxFormAction()
    {
        $request = $this->getRequest();
    	$params = $request->getParams();
	   	$orderId = $params['id'];
	   	$formName = $params['name'];
	    
	 	$order = $this->_purchaseOrderModel->findOneById($orderId);
	 	if (empty($order)) { throw new Zend_Controller_Action_Exception('Invalid Purchase Order'); }

		//create form
		$orderForm = new Shop_Form_PurchaseOrder();
		$orderForm->populate($order->toArray());
		$editor = new Application_Form_Editor();
		$editor->setAction($this->_helper->url('edit',null,null,array('name'=>$formName,'id'=>$orderId,'format'=>'json')));

    	switch($formName){
	    		case 'status':
	    		    $editor->addElement($orderForm->status_id);
	    		    break;
	    		default:
	    		    throw new Zend_Controller_Action_Exception('Invalid Form');
	    	}
	    
	    $editor->addSubmitButton();

	    $this->view->form = $editor;
    }


}









