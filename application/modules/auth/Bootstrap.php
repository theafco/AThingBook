<?php
class Auth_Bootstrap extends Zend_Application_Module_Bootstrap
{
    private $_view;
    /**
     * 
     * @return Zend_View
     */
    private function getView()
    {
    	if (null === $this->_view) {
    		$this->_view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
    	}
    	return $this->_view;
    }
    
    protected function _initHelper()
    {
        $front = Zend_Controller_Front::getInstance();
        
        //action helpers
        $moduleControllerPath = $front->getControllerDirectory('auth');
     	Zend_Controller_Action_HelperBroker::addPath($moduleControllerPath . '/actions/helpers','Auth_Controller_Action_Helper');
     	
     	//view helpers
     	$modulePath = $front->getModuleDirectory('auth');
     	$this->getView()->addHelperPath($modulePath . '/views/helpers','Auth_View_Helper');
    }
    
    protected function _initAutoLoader()
    {
        $front = Zend_Controller_Front::getInstance();
    	$rscloader = new Zend_Loader_Autoloader_Resource(array(
    			'basePath'	=>	$front->getModuleDirectory('auth'),
    			'namespace'	=>	''
    	));
    	$rscloader->addResourceTypes(array(
    		'model'	=>	array(
    				'path'		=>	'models',
    				'namespace'	=>	'Model'
    		),
    		'plugin'	=>	array(
    			'path'		=>	'controllers/plugins',
    			'namespace'	=>	'Controller_Plugin_',
    		),
    	));
    	
    	//plugins
    	$front->registerPlugin(new Controller_Plugin_Author());
    }
}