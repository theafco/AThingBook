<?php
class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->headline = 'หนังสือธรรมมะทั่วไป' . '<div style="float:right;margin:6px 6px 0 15px"><input type="text" /> <input type="submit" value="ค้นหา" /></div><a href="' . $this->_helper->url('index','product-index','shop',array('category'=>1)) . '" class="see_all" style="padding-right:.5em;border-right:1px solid #DBDBDB">ดูทั้งหมด</a>';
    }

    public function indexAction()
    {   
        //slider script
        $this->view->getHelper('headScript')
        	->appendFile('/js/libs/slideitmoo/mootools-1.2-core.js')
        	->appendFile('/js/libs/slideitmoo/mootools-1.2-more.js')
        	->appendFile('/js/libs/slideitmoo/SlideItMoo.js');

        //Set articles to view
        $normalBooks = $this->_helper->shop->getLastProductByCategory(1,4);
        $dedicatedBooks = $this->_helper->shop->getLastProductByCategory(2,4);
        $this->view->products = array(
        	'normalBook'	=>	$normalBooks,
        	'dedicatedBook'	=>	$dedicatedBooks,
        );

        $articles = $this->_helper->content->getLastArticleByCategory(1,4);
        $cartoons = $this->_helper->content->getLastArticleByCategory(2,4);
        $news = $this->_helper->content->getLastArticleByCategory(3,2);
        $this->view->contents = array(
        	'article'	=>	$articles,
        	'cartoon'	=>	$cartoons,
        );
        $this->_helper->layout()->rightWidgets = array($this->view->partial('./index/news_right_widget.phtml',array('news'=>$news)));
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



