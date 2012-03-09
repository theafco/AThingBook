<?php
class My_Controller_Plugin_FrontBackendLayout extends Zend_Controller_Plugin_Abstract
{
    private $_view = null;
    private $_isFrontend = true;
    /**
     * Is frontend or backend?
     * @return boolean
     */
    public function isFrontend()
    {
        return $this->_isFrontend;
    }
    
    private function getView()
    {
        if (empty($this->_view)) {
            $this->_view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');
        }
        return $this->_view;
    }
    
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $front = Zend_Controller_Front::getInstance();
        $modulePath = $front->getModuleDirectory();
        
    	$layout = Zend_Layout::getMvcInstance();
    	$controllerName = $request->getControllerName();
    	
    	if (strstr($controllerName, 'index')) {
    	    $layout->setLayout('frontend');  	    
    	} else if (strstr($controllerName, 'admin')) {
    	    $this->getView()->headLink()->appendStylesheet('/css/admin_common.css');
    	    $layout->setLayout('backend');
    	    $this->_isFrontend = false;
    	} else {
    	    throw new Zend_Controller_Dispatcher_Exception('Invalid Controller');
    	}	
    	//view scripts
    	$this->getView()->addScriptPath(APPLICATION_PATH . '/views/scripts/');
		$this->getView()->addScriptPath(APPLICATION_PATH . '/views/scripts/' . ($this->isFrontend()?'frontend':'backend') );

    	//module stylesheet
    	$cssPath = '/css/' . $request->getModuleName() . ( $this->isFrontend()?'_front':'_back') . '.css';
    	$this->getView()->headLink()->appendStylesheet($cssPath);
    	
    	//configs
    	$configsPath = $modulePath . '/configs';


    }
}
?>