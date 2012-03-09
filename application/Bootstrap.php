<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * 
     * @var Zend_View
     */
	private $_view;
	/**
	 * Return singleton view
	 * @return Zend_View
	 */
	private function getView()
	{
		if (null === $this->_view) {
			$this->bootstrap('view');
			$view = $this->getResource('view');
			$this->_view = $view;
		}
		return $this->_view;
	}
	
	public function init() {}
	
	protected function _initResource()
	{
	    //view helpers
		$this->getView()->addHelperPath('My/Views/Helpers','My_View_Helper');
		
		//action helpers
		Zend_Controller_Action_HelperBroker::addPrefix('My_Controller_Action_Helper');
// 		Zend_Controller_Action_HelperBroker::addHelper(new My_Controller_Action_Helper_Authenticate());
			
	}
	
	protected function _initAutoLoader()
	{
		$rscloader = new Zend_Loader_Autoloader_Resource(array(
				'basePath'	=>	APPLICATION_PATH,
				'namespace'	=>	''
		));
		$rscloader->addResourceTypes(array(
				'model'	=>	array(
						'path'		=>	'models/',
						'namespace'	=>	'Model_'
				),
		));
	}
	
	protected function _initHeader() 
	{
	    $view = $this->getView();
	    
	    $view->headMeta()->appendHttpEquiv(
	    		'Content-Type',
	    		'text/html; charset=utf8'
	    );
	    
		$view->headLink()->appendStylesheet('/css/common.css');
		
		$view->headScript()->appendFile('/js/common.js');
		
		$view->headTitle('A Thing Book');
		
	}

	protected function _initDoctrine()
	{
		require_once 'Doctrine.php';
		$loader = Zend_Loader_Autoloader::getInstance();
		$loader	->registerNamespace('Doctrine')
				->pushAutoloader(array('Doctrine', 'modelsAutoload'),'');
		//$this->getApplication()->getAutoloader()->pushAutoloader(array('Doctrine','autoload'),'Doctrine');
		
		$config = $this->getOption('doctrine');
		
		$manager = Doctrine_Manager::getInstance();
		$manager	->setAttribute(Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
		$manager	->setAttribute(Doctrine_Core::ATTR_MODEL_LOADING,Doctrine_Core::MODEL_LOADING_CONSERVATIVE);
		//			->setAttribute(Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, true)
					
		Doctrine_Core::loadModels($config['models_path']); 

		$manager	->openConnection($config['dsn'])->exec("SET NAMES 'UTF8'");
		$manager	->registerHydrator('key_value_pair', 'My_Doctrine_KeyValuePairHydrator');

		return $manager;
	}

	protected function _initSession()
	{
		Zend_Session::start();
	}
	
	protected function _initCurrency()
	{
	    $currency = new Zend_Currency(array(
	    	'locale' 	=> 'th_TH',
	    	'name'		=>	'บาท',
	    	'position'	=>	Zend_Currency::RIGHT,
	    ));
	    Zend_Registry::set('Zend_Currency', $currency);
	}
	
	protected function _initDojo()
	{
	    //enable dojo view helper
	    $this->getView()->addHelperPath('Zend/Dojo/View/Helper','Zend_Dojo_View_Helper');
		Zend_Dojo_View_Helper_Dojo::setUseDeclarative();
	}

}

