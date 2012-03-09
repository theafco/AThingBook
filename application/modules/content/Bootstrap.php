<?php
class Content_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initHelper()
    {
        //action helpers
        $moduleControllerPath = Zend_Controller_Front::getInstance()->getControllerDirectory('content');
     	Zend_Controller_Action_HelperBroker::addPath($moduleControllerPath . '/actions/helpers','Content_Controller_Action_Helper');
    }
    
    protected function _initAutoLoader()
    {
        $front = Zend_Controller_Front::getInstance();
    	$rscloader = new Zend_Loader_Autoloader_Resource(array(
    			'basePath'	=>	$front->getModuleDirectory('content'),
    			'namespace'	=>	''
    	));
    	$rscloader->addResourceTypes(array(
    		'model'	=>	array(
    				'path'		=>	'models/',
    				'namespace'	=>	'Model_'
    		),
    	));
    }
}