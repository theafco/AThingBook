<?php
require_once('BaseController.php');
class Shop_CartIndexController extends Shop_BaseController
{

    /**
     * @var Zend_Session_Namespace
     */
    private $_cartSession = null;

    public function init()
    {
        //check user permission
        $authHelper = $this->_helper->authen;
        $acl = $authHelper->getAcl();
        $user = $authHelper->getUser();
        if (!empty($user)) {
	        if (!$acl->isAllowed($user->role_id,'cart')) {
	            throw new Zend_Auth_Exception('No Permission');
	        }
        } else {
            throw new Zend_Auth_Exception('No Permission');
        }
        
        parent::init();
        
        $this->_cartSession = Zend_Registry::get('Shop_Cart_Session');
 
        //ajax context
        $this->_helper->ajaxContext
	        ->addActionContext('ajax-form', 'html')
	        ->addActionContext('add', 'json')
	        ->addActionContext('delete', 'json')
	        ->initContext();
    }

    public function indexAction()
    {
        $this->_helper->layout()->headline = 'ตะกร้าสินค้า';
	    $this->view->items = $this->_helper->shop->getCartItems();
    }

    public function addAction()
    {
    	$requrest = $this->getRequest();
        
   		if ($requrest->isPost()) {
            //collect inputs
            $input = $requrest->getPost();
            $params = $requrest->getParams();
            $productId = $params['id'];
            $quantity = $input['quantity'];
            
            //save order record session
	 		$this->_cartSession->items[$productId]['quantity'] = $quantity;
	 		
	        //set response
	    	$this->view->code = 0;
	     	$this->view->message = 'รายการถูกเพิ่มลงตะกร้าสินค้าเรียบร้อยแล้ว';
	     	
        } else {
            throw new Zend_Controller_Action_Exception('Require POST');
        } 
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
    	if ($request->isPost()) {
            //collect inputs
            $input = $request->getPost();
            $productCode = $this->_helper->shop->getProductCode($input['item']);
            
            //save order record session
	 		unset($this->_cartSession->items[$productCode]);

	        //set response
	    	$this->view->code = 0;
	     	
        } else {
            throw new Zend_Controller_Action_Exception('Require POST');
        }
    }

    public function ajaxFormAction()
    {
        $request = $this->getRequest();
        $formName = $request->getParam('name');
        $productId = $request->getParam('id');
        
        switch ($formName) {
        	case 'order':
        	case 'quantityEditor':
        	    $product = $this->_productModel->findOneBy('rowid', $productId);
        	    if (!empty($product)) {
	        	    //create product order form
	        	    $form = new Shop_Form_Order();
	        	    if (!empty($this->_cartSession->items[$productId]['quantity'])) {
	        	        $form->getElement('quantity')->setValue($this->_cartSession->items[$productId]['quantity']);
	        	    }
	        	    $form->setAction($this->_helper->url('add','cart-index','shop',array('id'=>$productId,'format'=>'json')));
	        	    $form->send->setAttrib('id', 'ok');
	        	    if ($formName == 'quantityEditor') {
	        	        $form->send->setLabel('บันทึก');
	        	    }
        	    } else {
        	        throw new Zend_Controller_Action_Exception('Invalid Product');
        	    }
        	    break;
        	default:
        	    throw new Zend_Controller_Action_Exception('Invalid Form');
        }
        
        $this->view->form = $form;
    }

    public function shippingAction()
    {
        $cartItems = $this->_helper->shop->getCartItems();
        if (empty($cartItems)) {
            throw new Zend_Controller_Action_Exception('Cart items not found');
        }
        $request = $this->getRequest();
        
    	$this->_helper->layout()->headline = 'ตรวจสอบข้อมูลการจัดส่งสินค้า';
        $user = $this->_helper->authen->getUser();
        
        $form = new Shop_Form_ShippingAddress();

        if ($request->isPost()) {
            $input = $request->getPost();

			if ($form->isValid($input)) {
                //save order
                $order = new Model_PurchaseOrder();
                $order->order_date = date('Y-m-d H:i:s');
                $order->user_id = $user->id;
                $order->status_id = 1;
                $order->shipping_name = $form->shipping_name->getValue();
                $order->shipping_address1 = $form->shippingAddress->address1->getValue();
                $order->shipping_subdistrict = $form->shippingAddress->subdistrict->getValue();
                $order->shipping_district = $form->shippingAddress->district->getValue();
                $order->shipping_province_code = $form->shippingAddress->province_code->getValue();
                $order->shipping_zipcode = $form->shippingAddress->zipcode->getValue();

                foreach ($cartItems as $code=>$item) {
                    $product = $item['product'];
                    $quantity = (int)$item['params']['quantity'];
	                $orderItem = new Model_PurchaseOrderItem();
	                $orderItem->code = $product->productCode;
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
                $this->_helper->redirector('complete');

            } else {
            	$this->view->shippingForm = $form;
            	$this->view->items = $cartItems;
            }
        } else {
            $form->shipping_name->setValue($user->first_name . ' ' . $user->last_name);
            $form->shippingAddress->address1->setValue($user->address1);
            $form->shippingAddress->subdistrict->setValue($user->subdistrict);
            $form->shippingAddress->district->setValue($user->district);
            $form->shippingAddress->province_code->setValue($user->province_code);
            $form->shippingAddress->zipcode->setValue($user->zipcode);

            $this->view->shippingForm = $form;
            $this->view->items = $cartItems;
        }
        
    }

    public function completeAction()
    {
    	$this->_helper->layout()->headline = 'การสั่งซื้อเสร็จสมบูรณ์';
        
        $message = $this->_helper->flashMessenger->getMessages();
        if (count($message)) {
            $orderId = $message[0];
            $order = $this->_purchaseOrderModel->findOneById($orderId);
            $this->view->order = $order;
        } else {
            $this->_redirect('/');
        }
    }

    public function poAction()
    {
    	$orderId = $this->getRequest()->getParam('id');
        if(!empty($orderId)) {
	        $order = $this->_purchaseOrderModel->findOneById($orderId);
	        $this->_helper->layout()->headline = 'ตรวจสอบใบสั่งซื้อ';
	        $this->view->order = $order;
        } else {
        	throw new Zend_Controller_Action_Exception('Invalid ID');
        }
    }


}













