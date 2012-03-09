<?php
require_once('BaseController.php');
class Auth_UserAdminController extends Auth_BaseController
{

    public function init()
    {
        $this->_helper->authen->protect();
        parent::init();

        //left-menu navigation
        $front = Zend_Controller_Front::getInstance();
        $this->view->navtitle = 'จัดการผู้ใช้';
        $config = new Zend_Config_Xml($front->getModuleDirectory() . '/configs/user-admin-menu.xml','navigation');
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
    	$q = $this->_userModel->createQuery('u');
    	if(!empty($keyword)){
	    	switch ($by){
	    		case 'id':
	    			$q->addWhere('u.id = ?', $keyword);
	    			break;
	    		case 'name':
	    			$q->addWhere('CONCAT_WS(\' \',u.first_name,u.last_name) LIKE ?','%' . $keyword . '%');
	    			break;
	    		case 'alias':
	    		case 'email':
	    			$q->addWhere("u.$by LIKE ?",'%' . $keyword . '%');
	    			break;
	    	}
    	}
    	
    	$gender = $params['gender'];
    	if(!empty($gender)){
    		$q->addWhere('u.gender = ?',$gender);
    	}
    	
    	$role = $params['role'];
    	if(!empty($role)){
    		$q->addWhere('u.role_id = ?',$role);
    	}
        
        $this->view->users = $q->execute();
        
    	$formSearch = new Auth_Form_UserSearchWithFilter();
    	$formSearch->setAction($this->_helper->url('index'));
    	$formSearch->populate($params);
    	
    	$this->view->searchForm = $formSearch;
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form = new Auth_Form_User();
    	
    	//don't need captcha
    	$form->removeElement('captcha');
    	
		if($request->isPost()){
			$input = $request->getPost();
			if ($form->isValid($input)) {
			    $form->removeElement('repassword');
				$user 	= 	new Model_User();
				$user->setArray($form->getValidValues($input));
				$user->created_date = date('Y-m-d H:i:s');
				$user->save();
				$this->_helper->redirector('index',null,null,array('keyword'=>$user->id,'searchBy'=>'id'));
			}
		}
		
		$form->setName('newUserForm');
		$form->send->setName('addNewUser')->setAttrib('label','เพิ่มผู้ใช้ใหม่');
		//clear password for security
		$form->password->setValue(null);
		$form->repassword->setValue(null);
		
		$this->view->newUserForm = $form;
		
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
    	if ($request->isPost()) {
    		$input = $request->getPost();
    		$params = $request->getParams();
    		$userId = $params['id'];
    		
    		if (empty($userId)) {
    		    throw new Zend_Controller_Action_Exception('Invalid User ID');
    		}

    		$user = $this->_userModel->findOneById($userId);
    		if (!empty($user)) {
    			$user->delete();
    			$this->view->code = 0;
    			$this->view->message = "ผู้ใช้รหัส $userId ถูกลบแล้ว";
    		} else {
    		    $this->view->code = -1;
    			$this->view->message = 'ไม่พบรายการผู้ใช้นี้';
    		}
    		
    	} else {
    	    throw new Zend_Controller_Action_Exception('Require Post');
    	}

    }

    public function viewAction()
    {
        $request = $this->getRequest();
        $params = $request->getParams();
    	$userId = $params['id'];

    	$user = $this->_userModel->findOneById($userId);

    	if (empty($user)) {
    	    throw new Zend_Controller_Action_Exception('Invalid User');
    	}
    	
    	$this->view->user = $user;
    }

    public function ajaxFormAction()
    {
        $request = $this->getRequest();
    	$params = $request->getParams();
	   	$userId = $params['id'];
	   	$formName = $params['name'];
	    
	 	$user = $this->_userModel->findOneById($userId);
	 	if (empty($user)) { throw new Zend_Controller_Action_Exception('Invalid User'); }

		//create form
		$userForm = new Auth_Form_User();
		$userForm->populate($user->toArray());
		$form = new Application_Form_Editor();
		$form->setAction($this->_helper->url('edit',null,null,array('name'=>$formName,'id'=>$userId,'format'=>'json')));

	    switch($formName){
	    	case 'name':
	    		$form	
	    			->addElement($userForm->first_name)
			   		->addElement($userForm->last_name);
		       	break;
	    	case 'alias':
	    	    $form
	    	    	->addElement($userForm->alias);
	    	    break;
	    	case 'gender':
	    		$form
	    			->addElement($userForm->gender);
	    		break;
	    	case 'birthday':
	    		$form
	    			->addElement($userForm->birthday);
	    		break;
	    	case 'address':
	    		$form
	    			->addElements(array(
		    			$userForm->address1,
		    			$userForm->subdistrict,
		    			$userForm->district,
		    			$userForm->province_code,
		    			$userForm->zipcode
		    		));
	    		break;
	    	case 'phone':
	    		$form
	    			->addElement($userForm->telephone)
	    			->addElement($userForm->mobilephone);
	    		break;
	    	case 'email':
	    		$form
	    			->addElement($userForm->email);
	    		break;
	    	case 'password':
	    		$form
	    			->addElement($userForm->password->setLabel('รหัสผ่านใหม่'))
	    			->addElement($userForm->repassword);
	    		//clear password
	    		$form->password->setValue(null);
	    		break;
	    	case 'role':
	    		$form
	    			->addElement($userForm->role_id);
	    		break;
	    	default:
	    		throw new Zend_Controller_Action_Exception('Invalid Form');
	    }
	    
	    $form->addSubmitButton();

	    $this->view->form = $form;

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

}













