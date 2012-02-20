<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected $_view;
	
	public function init()
	{
		return $this->getView();
	}
	
	private function getView() 
	{
		if (null === $this->_view) {
			//$view = new Zend_View();
			$this->bootstrap('view');
			$view = $this->getResource('view');
			$this->_view = $view;
			/* // Set the view renderer to use the view
		    $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		    $viewRenderer->setView($view);*/
		}
		return $this->_view;
	}

	protected function _initViewHelper()
	{
		$this->getView()
			->addHelperPath('Zend/Dojo/View/Helper','Zend_Dojo_View_Helper')
			->addHelperPath('My/Dojo/View/Helper','My_Dojo_View_Helper')
			->addHelperPath('My/Views/Helpers','My_View_Helper');
	}

	protected function _initHeadMeta() 
	{
		$this->getView()->headMeta()->appendHttpEquiv(
			'Content-Type',
			'text/html; charset=utf8'
		);
	}
	
	protected function _initStyleSheet() 
	{
		$this->getView()->headLink()->appendStylesheet('/css/common.css');
	}
	
	protected function _initScript()
	{
		$this->getView()->headScript()->appendFile('/js/common.js');
	}
	
	protected function _initTitle() 
	{
		$this->getView()->headTitle('A Thing Book');
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
	
	protected function _initAutoLoader()
	{
		$rscloader = new Zend_Loader_Autoloader_Resource(array(
			'basePath'	=>	APPLICATION_PATH,
			'namespace'	=>	''
		));
		$rscloader->addResourceTypes(array(
			/*'form'	=>	array(
				'path'		=>	'forms/',
				'namespace'	=>	'Form_'
			),*/
			'model'	=>	array(
				'path'		=>	'models/',
				'namespace'	=>	'Model_'
			),
		));
	}
	
	protected function _initActionHelper()
	{
		Zend_Controller_Action_HelperBroker::addPrefix('My_Controller_Action_Helper');
		Zend_Controller_Action_HelperBroker::addHelper(new My_Controller_Action_Helper_Authenticate());
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
		Zend_Dojo_View_Helper_Dojo::setUseDeclarative();
	}

}

