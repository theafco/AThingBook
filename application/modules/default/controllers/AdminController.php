<?php

class Default_AdminController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $user = $this->_helper->authen->getUser();
        if (!empty($user)) {
            if ($user->role->is_admin) {
                $this->render('dashboard');
            } else {
                throw new Zend_Auth_Exception('No Permission');
            }
        } else {
            $this->_helper->layout()->disableLayout();
        }
    }

}





