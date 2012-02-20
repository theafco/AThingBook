<?php
class My_Controller_Plugin_LayoutPerModule extends Zend_Controller_Plugin_Abstract
{

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
    	// Set the layout directory for the loaded module
    	$layoutPath = APPLICATION_PATH . '/modules/' . $request->getModuleName() . '/layouts/scripts/';
    	Zend_Layout::getMvcInstance()->setLayoutPath($layoutPath);
   
   		// Configure the error plugin to use the loaded module
   		// so we can use module-specific error handling
   		$frontController = Zend_Controller_Front::getInstance();
   		$errorPlugin     = $frontController->getPlugin('Zend_Controller_Plugin_ErrorHandler');
   		$errorPlugin->setErrorHandlerModule($request->getModuleName());
    }

}
?>