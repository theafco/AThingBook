<?php
class Admin_UserController extends Zend_Controller_Action
{

    private $user_model;
    
    public function init()
    {
        $this->user_model = new Model_User();
        
        //Enable Dojo View Helper
		Zend_Dojo::enableView($this->view);
		
		//Create left menu
		$config = new Zend_Config_Xml(APPLICATION_PATH . '/modules/admin/configs/user_leftnav.xml','navigation');
		$container = new Zend_Navigation($config);
		$this->view->navigation($container);
		
		$uri = $this->_request->getPathInfo();
		$activeNav = $this->view->navigation()->findByUri($uri);
		$activeNav->active = true;
    }

    public function indexAction()
    {  
    	$users = $this->user_model->findAll();
    	$this->view->users = $users;
    	
    	$formSearch = new Application_Form_UserSearchWithFilter();
    	$formSearch->setAction('/admin/user/search');
    	$this->view->formSearch = $formSearch;

    }

    public function addAction()
    {
    	$form = new Application_Form_NewUser();
    	
		if($this->getRequest()->isPost()){
			
			if($form->isValid($this->getRequest()->getPost())) {
				$user 	= 	new Model_User();
				$user->email 		=	$form->getValue('email');
				$user->password 	=	md5($form->getValue('password'));
				$user->first_name 	=	$form->getValue('first_name');
				$user->last_name 	=	$form->getValue('last_name');
				$user->alias		=	$form->getValue('alias');
				$user->gender		=	$form->getValue('gender');
				$user->birthday		=	$form->getValue('birthday');
				$user->address		=	$form->getValue('address');
				$user->subdistrict	=	$form->getValue('subdistrict');
				$user->district		=	$form->getValue('district');
				$user->province		=	$form->getValue('province');
				$user->zipcode		=	$form->getValue('zipcode');
				$user->telephone	=	$form->getValue('telephone');
				$user->mobilephone	=	$form->getValue('mobilephone');
				$user->news_letter_allowed	=	$form->getValue('news_letter_allowed');
				$user->created_date	=	date('Y-m-d H:i:s');
				$user->role_id		=	$form->getValue('role_id');
				$user->save();
				$this->_helper->redirector('search',null,null,array('keyword'=>$user->id,'by'=>'id'));
				exit();
			}
		}
		
		$form->setAction($this->_helper->url('add','user','admin'));
		$this->view->form = $form;
    }

    public function viewAction()
    {
    	$itemid = $this->getRequest()->getParam('item');
    	$user = $this->user_model->findOneById($itemid);
    	$this->_helper->layout()->disableLayout();
    	
    	if(false===$user){
    		return false;
    	}
    	
        $this->view->user = $user;
    }

    public function editAction()
    {
    	$itemid = $this->getRequest()->getParam('item');
    	$section_name = $this->getRequest()->getParam('name');
    	//disbale layout
    	$this->_helper->layout()->disableLayout();
    	
    	$form = new Application_Form_NewUser();
    	if($this->getRequest()->isPost()){
    		if($form->isValidPartial($this->getRequest()->getPost())){
    			//valid data
    			$user = $this->user_model->findOneById($itemid);
		        if (false === $user){
		    		$result = array('code'=>-1,'message'=>'ไม่พบผู้ใช้');
		    	} else {
		    	    switch($section_name){
		    	    	case 'name':
		    	    		$user->first_name = $form->getValue('first_name');
		    	    		$user->last_name = $form->getValue('last_name');
		    	    		$message = $user->first_name . ' ' . $user->last_name;
		    	    		break;
		    	    	case 'alias':
		    	    	    $user->alias = $form->getValue('alias');
		    	    	    $message = $user->alias;
		    	    	    break;
		    	    	case 'gender':
		    	    	    $user->gender = $form->getValue('gender');
		    	    	    $message = $this->view->gender($user->gender);
		    	    		break;
		    	    	case 'birthday':
		    	    	    $user->birthday = $form->getValue('birthday');
		    	    	    $message = $user->birthday;
		    	    		break;
		    	    	case 'address':
		    	    	    $user-> 
		    	    		$user->address = $form->getValue('address');
		    	    		$user->subdistrict = $form->getValue('subdistrict');
		    	    		$user->district = $form->getValue('district');
		    	    		$user->province = $form->getValue('province');
		    	    		$user->zipcode = $form->getValue('zipcode');
		    	    		$arr_address = array(
								'address'		=>	$user->address,
								'subdistrict'	=>	$user->subdistrict,
								'district'		=>	$user->district,
								'province'		=>	$user->province,
								'zipcode'		=>	$user->zipcode
							);
		    	    		$message = $this->view->address($arr_address);
		    	    		break;
		    	    	case 'phone':
		    	    	    $user->telephone = $form->getValue('telephone');
		    	    	    $user->mobilephone = $form->getValue('mobilephone');
		    	    	    $phones = array('home'=>$user->telephone, 'mobile'=>$user->mobilephone);
		    	    	    $message = $this->view->phonenumber($phones);
		    	    	    break;
		    	    	case 'email':
		    	    		$user->email = $form->getValue('email');
		    	    		$message = $user->email;
		    	    		break;
		    	    	case 'password':
		    	    		$user->password = md5($form->getValue('password'));
		    	    		$message = 'ข้อมูลลับ';
		    	    		break;
		    	    	case 'role':
		    	    		$user->role_id = $form->getValue('role_id');
		    	    		$message = $user->role->name;
		    	    		break;
		    	    }
		    	    //save record
		    	    $user->save();
		    	    $result = array('code'=>0,'message'=>$message);
		    	}
		    } else {
		    	//invalid data
		        $result = array('code'=>-1,'message'=>'ข้อมูลไม่ถูกต้อง');
		    }
    	} else {
    		$this->_helper->layout()->disableLayout();
    		throw new Zend_Controller_Action_Exception('Submission is not posted.', 404);
    	}
        $this->_helper->json($result);
    }

    public function editorAction()
    {
    	$itemid = $this->getRequest()->getParam('item');
    	$editor_name = $this->getRequest()->getParam('name');
    	
        $user = $this->user_model->findOneById($itemid,Doctrine_Core::HYDRATE_ARRAY);

    	//disbale layout
    	$this->_helper->layout()->disableLayout();
    	
    	//Check user
    	if(false === $user){
    		return false;
    	}

		$user_form = new Application_Form_NewUser();
		$form = new Zend_Form();
    	switch($editor_name){
    		case 'name':
    			$form	->addElement($user_form->getElement('first_name'))
	    				->addElement($user_form->getElement('last_name'));
	        	break;
    		case 'alias':
    		    $form	->addElement($user_form->getElement('alias'));
    		    break;
    		case 'gender':
    			$form	->addElement($user_form->getElement('gender')->setValue(true));
    			break;
    		case 'birthday':
    			$form	->addElement($user_form->getElement('birthday'));
    			break;
    		case 'address':
    			$form	->addElement($user_form->getElement('address'))
    					->addElement($user_form->getElement('subdistrict'))
    					->addElement($user_form->getElement('district'))
    					->addElement($user_form->getElement('province'))
    					->addElement($user_form->getElement('zipcode'));
    			break;
    		case 'phone':
    			$form	->addElement($user_form->getElement('telephone'))
    					->addElement($user_form->getElement('mobilephone'));
    			break;
    		case 'email':
    			$form	->addElement($user_form->getElement('email'));
    			break;
    		case 'password':
    			$form	->addElement($user_form->getElement('password')->setLabel('รหัสผ่านใหม่'))
    					->addElement($user_form->getElement('repassword'));
    			break;
    		case 'role':
    			$form	->addElement($user_form->getElement('role_id'));
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
    			->setAction($this->_helper->url('edit','user','admin',$urlParams))
    			->setDecorators($form_decorators)
    			->populate($user)
    			->addElement($user_form->getElement('send')->setAttrib('label','บันทึก'))
    			->addElement($cancel_button);
    	$this->view->form = $form;
    }

    public function searchAction()
    {
        $formSearch = new Application_Form_UserSearchWithFilter();
        $formSearch->setAction('/admin/user/search');
        $input = $this->getRequest()->getParams();
        //filtered input
        $formSearch->isValid($input);
        $keyword = $formSearch->getValue('keyword');
        $gender = $formSearch->getValue('gender');
        $role = $formSearch->getValue('role');
        
        $q = $this->user_model->createQuery('u');
        
    	//if($this->getRequest()->isGet()){
    		
    		//add validators
    		$notEmpty = new Zend_Validate_NotEmpty();
    		//create query
    		
			//Filter-based Search Engine
    		if($notEmpty->isValid($keyword)){
	    		switch ($input['by']){
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
	    		}
    		}
    		
    		if($notEmpty->isValid($gender)){
    			$q->addWhere('u.gender = ?',$gender);
    		}
    		
    		if($notEmpty->isValid($role)){
    			$q->addWhere('u.role_id = ?',$role);
    		}
    	//}
    	
    	$formSearch->populate($input);
    	$this->view->formSearch = $formSearch;
    	
        $users = $q->execute(array(),Doctrine_Core::HYDRATE_RECORD);
		$this->view->users = $users;
		$this->_helper->viewRenderer('index');
    }

    public function deleteAction()
    {
    	if ($this->getRequest()->isPost()) {
    		$input = $this->getRequest()->getPost();
    		$id = $input['item'];
    	}
    	if (!empty($id)) {
        	$user = $this->user_model->findOneById($id);
        	if ($user) {
        	    $user->is_deleted  = true;
        		$user->save();
        		$result = 0;
        	} else {
        		$result = 'ไม่พบรายการ';
        	}
        	$this->view->result = $result;
    	}
    	$this->_helper->layout()->disableLayout();
    }


}


