<?php
class Admin_UserController extends Zend_Controller_Action
{
    private $_userModel;
    
    public function init()
    {
        $this->_userModel = new Model_User();
		
        //dojo widget dialog theme
        $this->view->getHelper('headLink')->appendStylesheet('/js/libs/dojo/1.7.1/dojox/widget/Dialog/Dialog.css');
        
// 		//Create left menu
// 		$this->view->navtitle = 'จัดการผู้ใช้';
// 		$config = new Zend_Config_Xml(APPLICATION_PATH . '/modules/admin/configs/user_leftnav.xml','navigation');
// 		$container = new Zend_Navigation($config);
// 		$this->view->navigation($container);
		
// 		$uri = $this->_request->getPathInfo();
// 		$activeNav = $this->view->navigation()->findByUri($uri);
// 		$activeNav->active = true;
		
// 		$this->_helper->ajaxContext
// 			->addActionContext('view', 'html')
// 			->addActionContext('editor', 'html')
// 			->addActionContext('edit', 'json')
// 			->addActionContext('delete', 'json')
// 			->initContext();
    }

    public function indexAction()
    {  
//     	$this->view->users = $this->_userModel->findAll();
    	
//     	$formSearch = new Application_Form_UserSearchWithFilter();
//     	$this->view->searchForm = $formSearch;

    }

    public function addAction()
    {
//     	$form = new Auth_Form_User();
    	
// 		if($this->getRequest()->isPost()){
			
// 			if($form->isValid($this->getRequest()->getPost())) {
// 				$user 	= 	new Model_User();
// 				$user->email 		=	$form->getValue('email');
// 				$user->password 	=	md5($form->getValue('password'));
// 				$user->first_name 	=	$form->getValue('first_name');
// 				$user->last_name 	=	$form->getValue('last_name');
// 				$user->alias		=	$form->getValue('alias');
// 				$user->gender		=	$form->getValue('gender');
// 				if ($form->getValue('birthday')) {
// 				    $user->birthday		=	$form->getValue('birthday');
// 				}
// 				$user->address1		=	$form->address->getValue('address1');
// 				$user->subdistrict	=	$form->address->getValue('subdistrict');
// 				$user->district		=	$form->address->getValue('district');
// 				$user->province_code=	$form->address->getValue('province_code');
// 				$user->zipcode		=	$form->address->getValue('zipcode');
// 				$user->telephone	=	$form->getValue('telephone');
// 				$user->mobilephone	=	$form->getValue('mobilephone');
// 				$user->news_letter_allowed	=	$form->getValue('news_letter_allowed');
// 				$user->created_date	=	date('Y-m-d H:i:s');
// 				$user->role_id		=	$form->getValue('role_id');
// 				$user->save();
// 				$this->_helper->redirector('search',null,null,array('keyword'=>$user->id,'by'=>'id'));
// 				exit();
// 			}
// 		}
		
// 		$form->password->setValue(null);
// 		$form->repassword->setValue(null);
// 		$this->view->form = $form;
    }

    public function viewAction()
    {
//    		$itemId = $this->getRequest()->getParam('item');
//     	$user = $this->_userModel->findOneById($itemId);
    	    
//     	if (!empty($user)) {
//     		$this->view->user = $user;
//     	} else {
//     		throw new Zend_Controller_Action_Exception('Invalid User',404);
//     	}
    }

    public function editAction()
    {  	
//         $userForm = new Auth_Form_User();
//     	$form = new Zend_Form();
//     	$form->addSubForm($userForm, 'editorSubForm');
    	
//     	if($this->getRequest()->isPost()){
//     	    $input = $this->getRequest()->getPost();
//     	    //form validation
//     	    $subForm = $form->editorSubForm;
//     	    if($form->isValidPartial($input)){
//     	        $itemId = $input['item'];
//     	        $editorName = $input['editor'];
//     			$user = $this->_userModel->findOneById($itemId);
//     			if (!empty($user)) {
// 			    	switch($editorName){
// 			    	    case 'name':
// 			    	    	$user->first_name = $subForm->getValue('first_name');
// 			    	    	$user->last_name = $subForm->getValue('last_name');
// 			    	    	$message = $user->name;
// 			    	    	break;
// 			    	    case 'alias':
// 			    	        $user->alias = $subForm->getValue('alias');
// 			    	        $message = $user->alias;
// 			    	        break;
// 			    	    case 'gender':
// 			    	        $user->gender = $subForm->getValue('gender');
// 			    	        $message = $user->genderText;
// 			    	    	break;
// 			    	    case 'birthday':
// 			    	        $birthday = $subForm->getValue('birthday');
// 			    	        if (!empty($birthday)) {
// 			    	            $user->birthday = $subForm->getValue('birthday');
// 			    	            $date = new Zend_Date();
// 			    	            $message = $date->set($user->birthday)->get(Zend_Date::DATE_LONG);
// 			    	        } else {
// 			    	            $user->birthday = null;
// 			    	            $message = '<span class="grayOut">ไม่ระบุ</span>';
// 			    	        }
// 			    	    	break;
// 			    	    case 'address':
// 			    	    	$user->address1 = $subForm->address->getValue('address1');
// 			    	    	$user->subdistrict = $subForm->address->getValue('subdistrict');
// 			    	    	$user->district = $subForm->address->getValue('district');
// 			    	    	$user->province_code = $subForm->address->getValue('province_code');
// 			    	    	$user->zipcode = $subForm->address->getValue('zipcode');
// 			    	    	$message = $user->address;
// 			    	    	break;
// 			    	    case 'phone':
// 			    	        $telephone = $subForm->getValue('telephone');
// 			    	        $mobilephone = $subForm->getValue('mobilephone');
// 			    	        $user->telephone = $telephone;
// 			    	        $user->mobilephone = $mobilephone;
// 			    	        if (!empty($telephone) || !empty($mobilephone)) {
// 			    	            $message = $user->phone;
// 			    	        } else {
// 			    	            $message = '<span class="grayOut">ไม่ระบุ</span>';
// 			    	        }
// 			    	        break;
// 			    	    case 'email':
// 			    	    	$user->email = $subForm->getValue('email');
// 			    	    	$message = $user->email;
// 			    	    	break;
// 			    	    case 'password':
// 			    	    	$user->password = md5($subForm->getValue('password'));
// 			    	    	$message = 'ข้อมูลลับ';
// 			    	    	break;
// 			    		case 'role':
// 			    			$user->role_id = $subForm->getValue('role_id');
// 			    			$message = $user->role->name;
// 			    		break;
// 			    	}
// 			 		//save record
// 			    	$user->save();
			    	    
// 			    	$this->view->code = 0;
// 			    	$this->view->message = $message;
//     			} else {
//     			    throw new Zend_Controller_Action_Exception('Invalid User', 404);
//     			}
// 		    } else {
// 		    	$this->view->code = -1;
// 		    	$this->view->message = 'ข้อมูลไม่ถูกต้อง';
// 		    }
//     	} else {
//     		throw new Zend_Controller_Action_Exception('Require Post', 404);
//     	}

    }

    public function editorAction()
    {
//       	$input = $this->getRequest()->getParams();
// 	   	$itemId = $input['item'];
// 	   	$editorName = $input['editor'];
	    	
// 	 	$user = $this->_userModel->findOneById($itemId);
// 	 	if (!empty($user)) {
// 			//create editor form
// 			$userForm = new Auth_Form_User();
// 			$form = new Application_Form_Editor();
// 			$editorSubForm = $form->editorSubForm;
// 	    	switch($editorName){
// 	    		case 'name':
// 	    			$editorSubForm->addElement($userForm->getElement('first_name'))
// 		    				->addElement($userForm->getElement('last_name'));
// 		        	break;
// 	    		case 'alias':
// 	    		    $editorSubForm->addElement($userForm->getElement('alias'));
// 	    		    break;
// 	    		case 'gender':
// 	    			$editorSubForm->addElement($userForm->getElement('gender')->setValue(true));
// 	    			break;
// 	    		case 'birthday':
// 	    			$editorSubForm->addElement($userForm->getElement('birthday'));
// 	    			break;
// 	    		case 'address':
// 	    			$editorSubForm->addElements($userForm->getSubForm('address')->getElements());
// 	    			break;
// 	    		case 'phone':
// 	    			$editorSubForm->addElement($userForm->getElement('telephone'))
// 	    					->addElement($userForm->getElement('mobilephone'));
// 	    			break;
// 	    		case 'email':
// 	    			$editorSubForm->addElement($userForm->getElement('email'));
// 	    			break;
// 	    		case 'password':
// 	    			$editorSubForm->addElement($userForm->getElement('password')->setLabel('รหัสผ่านใหม่'))
// 	    					->addElement($userForm->getElement('repassword'));
// 	    			break;
// 	    		case 'role':
// 	    			$editorSubForm->addElement($userForm->getElement('role_id'));
// 	    			break;
// 	    		default:
// 	    			throw new Zend_Controller_Action_Exception('Invalid Editor',404);
// 	    	}

// 	    	$form->populate($user->toArray());
// 	    	//clear password textbox
// 	    	if ($editorName == 'password') {
// 	    	    $editorSubForm->password->setValue(null);
// 	    	}
// 	    	$form->editor->setValue($editorName);
// 	    	$form->item->setValue($itemId);
// 	    	$this->view->editorForm = $form;
// 	    } else {
// 	    	throw new Zend_Controller_Action_Exception('Invalid User',404);
// 	    }
    }

    public function searchAction()
    {
        $form = new Application_Form_UserSearchWithFilter();
        $input = $this->getRequest()->getParams();

        $keyword = $input['keyword'];
		$by = $input['searchBy'];
        
        
        $q = $this->_userModel->createQuery('u');

		//Filter-based Search Engine
    	if(!empty($keyword)){
	    	switch ($by){
	    		case 'id':
	    			$q->addWhere('u.id = ?', $keyword);
	    			break;
	    		case 'name':
	    			$q->addWhere('CONCAT_WS(\' \',u.first_name,u.last_name) LIKE ?','%' . $keyword . '%');
	    			break;
	    		case 'alias':
	    			$q->addWhere('u.alias LIKE ?','%' . $keyword . '%');
	    			break;
	    		case 'email':
	    			$q->addWhere('u.email LIKE ?','%' . $keyword . '%');
	    			break;
	    	}
    	}
    	
    	$gender = $input['filter']['gender'];
    	if(!empty($gender)){
    		$q->addWhere('u.gender = ?',$gender);
    	}
    	
    	$role = $input['filter']['role'];
    	if(!empty($role)){
    		$q->addWhere('u.role_id = ?',$role);
    	}
    	
    	$form->populate($input);
    	
		$this->view->users = $q->execute();
		$this->view->searchForm = $form;
		$this->render('index');
    }

    public function deleteAction()
    {
//     	if ($this->getRequest()->isPost()) {
//     		$input = $this->getRequest()->getPost();
//     		$itemId = $input['item'];
    		
//     		if (!empty($itemId)) {
//     			$user = $this->_userModel->findOneById($itemId);
//     			if (!empty($user)) {
//     				$user->delete();
//     				$this->view->code = 0;
//     				$this->view->message = "ผู้ใช้รหัส $itemId ถูกลบแล้ว";
//     			} else {
//     			    $this->view->code = -1;
//     			    $this->view->message = 'ไม่พบผู้ใช้';
//     			}
//     		} else {
//     		    throw new Zend_Controller_Action_Exception('Require User ID',404);
//     		}
//     	} else {
//     	    throw new Zend_Controller_Action_Exception('Require Post',404);
//     	}
    }

}


