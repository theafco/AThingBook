<?php
require_once('BaseController.php');
class Auth_UserIndexController extends Auth_BaseController
{

    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        
    }

    public function addAction()
    {
        $form = new Auth_Form_User();
        //hide role selection
        $form->removeElement('role_id');
        $roleElement = new Zend_Form_Element_Hidden('role_id',array(
        		'value'	=>	Model_Role::USER_REGISTERED_USER,
        ));
        $roleElement->removeDecorator('label')->removeDecorator('htmlTag')->setOrder(0);
        $form->addElement($roleElement);
        
        $form->send->setAttrib('label','สมัครสมาชิก');
        $this->view->userForm = $form;
    }

}







