<?php
require_once('BaseController.php');
class Auth_BaseController extends Zend_Controller_Action
{
    /**
     * @var Model_User
     */
    protected $_userModel = null;

    public function init()
    {
        $this->_userModel = new Model_User();
    }
}

