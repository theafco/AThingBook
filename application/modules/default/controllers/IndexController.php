<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->headline = 'หนังสือธรรมมะทั่วไป' . '<a href="' . $this->_helper->url('index','product',null,array('cat'=>1)) . '" class="see_all">ดูทั้งหมด</a>';
    }

    public function indexAction()
    {
        //dojo dialog theme
        $this->view->getHelper('headLink')->appendStylesheet('/js/libs/dojo/1.7.1/dojox/widget/Dialog/Dialog.css');
        
        //slider script
        $this->view->getHelper('headScript')
        	->appendFile('/js/libs/slideitmoo/mootools-1.2-core.js')
        	->appendFile('/js/libs/slideitmoo/mootools-1.2-more.js')
        	->appendFile('/js/libs/slideitmoo/SlideItMoo.js');
        
        //Set contents to view
        $this->view->normalBooks = $this->_helper->product->getLastestProductByCategory(1,4);
        $this->view->dedicatedBooks = $this->_helper->product->getLastestProductByCategory(2,4);
        $this->view->contents = $this->_helper->content->getLastestContentByCategory(1,4);
        $this->view->cartons = $this->_helper->content->getLastestContentByCategory(2,4);
        //$this->view->news = $this->_helper->content->getLastestContentByCategory(3,4);
    }

    public function staticContentAction()
    {
        $page = $this->getRequest()->getParam('page');
        $scriptFile = $this->view->getScriptPath(null) . $this->getRequest()->getControllerName() . "/$page." . $this->viewSuffix;
        if (file_exists($scriptFile)) {
            $this->render($page);
        } else {
            throw new Zend_Controller_Action_Exception('Page Not Found:'. $scriptFile ,404);
        }
    }


}



