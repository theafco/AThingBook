<?php
class Auth_View_Helper_Authen extends Zend_View_Helper_Abstract
{
    public function authen($adminMode=false)
    {
        return $this->getAuthView($adminMode);
    }
    /**
     * Return auth partial view
     * @return string|Zend_View_Helper_Partial|Auth_Form_Login
     */
    public function getAuthView($adminMode=false)
    {
        if ($adminMode) {
        	$controllerName = 'auth-admin';
        } else {
        	$controllerName = 'auth-index';
        }
        
    	$modulePath = Zend_Controller_Front::getInstance()->getModuleDirectory('auth');
    	$this->view->addScriptPath($modulePath . '/views/scripts/' . $controllerName);
    	
    	$user = Zend_Controller_Action_HelperBroker::getStaticHelper('authen')->getUser();
    	if (!empty($user)) {
    	    
    	    return $this->view->partial('loggedin-partial.phtml',array('user'=>$user));
    	    
    	} else {
    		$form = new Auth_Form_Login();
    		$form->setAction($this->view->url(array('action'=>'login','controller'=>$controllerName,'module'=>'auth','format'=>'json')));
    		
    		$form->setDecorators(array(
    				array('ViewScript', array('viewScript' => 'login-form.phtml'))
    		));
    
    		return $form;
    	}
    }
}
?>