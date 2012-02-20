<?php

class Default_CartController extends Zend_Controller_Action
{

    /**
     * @var Model_Product
     * 
     * 
     * 
     *
     */
    private $_productModel = null;

    /**
     * @var Model_ProductOrder
     *
     *
     *
     *
     */
    private $_productOrderModel = null;

    /**
     * @var Model_ProductOrderItem
     *
     *
     *
     *
     */
    private $_productOrderItemModel = null;

    /**
     * @var Zend_Session_Namespace
     *
     */
    private $_cartSession = null;

    public function init()
    {
        //dojo dialog theme
        $this->view->getHelper('headLink')
        	->appendStylesheet('/js/dojo/dojox/widget/Dialog/Dialog.css')
        	->appendStylesheet('/css/default_cart.css');
        
        $this->_productModel = new Model_Product();
        $this->_productOrderModel = new Model_ProductOrder();
        $this->_productOrderItemModel = new Model_ProductOrderItem();
        
        //Create cart session
        $this->_cartSession = new Zend_Session_Namespace('cart',true);

        $this->_helper->ajaxContext
        	->addActionContext('ajax-form', 'html')
        	->addActionContext('order', 'json')
        	->initContext();
        
//         $this->_cartSession->unsetAll();
//         Zend_Debug::dump($this->_cartSession);
//         Zend_Debug::dump($_SESSION);
//         die();
    }

    public function indexAction()
    {
        $this->_helper->layout()->headline = 'ตะกร้าสินค้า';
	    $this->view->items = $this->_helper->product->getCartItems($this->_cartSession);
    }

    public function orderAction()
    {
        if ($this->getRequest()->isPost()) {
            //collect inputs
            $input = $this->getRequest()->getPost();
            $productCode = $input['item'];
            $quantity = $input['quantity'];
            
            //save order record session
	 		$this->_cartSession->items[$productCode]['quantity'] = $quantity;
	 		
	        //set response
	    	$this->view->code = 0;
	     	$this->view->message = 'รายการถูกเพิ่มลงตะกร้าสินค้าเรียบร้อยแล้ว';
	     	
        } else {
            throw new Zend_Controller_Action_Exception('Require POST',403);
        }
    }

    public function order1Action()
    {
        $this->_helper->layout()->headline = 'ตรวจสอบข้อมูลการจัดส่งสินค้า';
        //TODO: get loggedin user
        $user = $this->_helper->authenticate->getUser();
        
        $form = new Application_Form_ShippingAddress();
        $form->setMethod('post');

        if ($this->getRequest()->isPost()) {
            $input = $this->getRequest()->getPost();

			if ($form->isValid($input)) {

                //save order
                $order = new Model_ProductOrder();
                $order->order_date = date('Y-m-d H:i:s');
                $order->user = $user;
                $order->shipping_name = $form->shipping_name->getValue();
                $order->shipping_address = $form->shippingAddress->address->getValue();
                $order->shipping_subdistrict = $form->shippingAddress->subdistrict->getValue();
                $order->shipping_district = $form->shippingAddress->district->getValue();
                $order->shipping_province_code = $form->shippingAddress->province_code->getValue();
                $order->shipping_zipcode = $form->shippingAddress->zipcode->getValue();

                $items = $this->_helper->product->getCartItems($this->_cartSession);
                foreach ($items as $code=>$item) {
                    $product = $item['product'];
                    $quantity = (int)$item['params']['quantity'];
	                $orderItem = new Model_ProductOrderItem();
	                $orderItem->code = $code;
	                $orderItem->name = $product->name;
	                $orderItem->quantity = $quantity;
	                $orderItem->unit_price = $product->price;
	                $orderItem->unit_total_price = $orderItem->unit_price * $quantity;
	                $order->total_price += $orderItem->unit_total_price;
	                $order->items[] = $orderItem;
                }
                $order->save();
                $this->_cartSession->unsetAll();
                $this->_helper->flashMessenger($order->id);
                $this->_helper->redirector('order2');

            } else {
            	$this->view->shippingForm = $form;
            	$this->view->items = $this->_helper->product->getCartItems($this->_cartSession);
            }
        } else {
            
            $form->shipping_name->setValue($user->first_name . ' ' . $user->last_name);
            $form->shippingAddress->address->setValue($user->address);
            $form->shippingAddress->subdistrict->setValue($user->subdistrict);
            $form->shippingAddress->district->setValue($user->district);
            $form->shippingAddress->province_code->setValue($user->province_code);
            $form->shippingAddress->zipcode->setValue($user->zipcode);

            $this->view->shippingForm = $form;
            $this->view->items = $this->_helper->product->getCartItems($this->_cartSession);
        }
        
    }

    public function order2Action()
    {
        $message = $this->_helper->flashMessenger->getMessages();
        if (count($message)) {
            $orderId = $message[0];
            $order = $this->_productOrderModel->findOneById($orderId);
            $this->view->order = $order;
        } else {
            $this->_helper->redirector('index','index');
        }
    }
    
    public function summaryAction()
    {
        $orderId = $this->getRequest()->getParam('item');
        if(!empty($orderId)) {
	        $order = $this->_productOrderModel->findOneById($orderId);
	        $this->_helper->layout()->headline = 'ตรวจสอบใบสั่งซื้อ';
	        $this->view->order = $order;
        } else {
        	throw new Zend_Controller_Action_Exception('Invalid Item',404);
        }
    }

    public function ajaxFormAction()
    {
        $formName = $this->getRequest()->getParam('name');
        $productId = $this->getRequest()->getParam('item');
        
        switch ($formName) {
        	case 'order':
        	    //get product code
        	    $productCode = $this->_helper->product->getProductCode($productId);
        	    if (!$productCode) {
        	        throw new Zend_Controller_Action_Exception('Invalid Product','404');
        	    }
        	    //create product order form
        	    $form = new Application_Form_Order();
        	    $form->getElement('item')->setValue($productCode);
        	    if (!empty($this->_cartSession->items[$productCode]['quantity'])) {
        	        $form->getElement('quantity')->setValue($this->_cartSession->items[$productCode]['quantity']);
        	    }
        	    $form->setAction($this->_helper->url('order',null,null,array('format'=>'json')));
        	    break;
        	default:
        	    throw new Zend_Controller_Action_Exception('Invalid form','404');
        }
        
        $this->view->form = $form;

    }




}











