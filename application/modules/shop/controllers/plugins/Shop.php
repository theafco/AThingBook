<?php
class Controller_Plugin_Shop extends Zend_Controller_Plugin_Abstract
{

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $cartSession = new Zend_Session_Namespace('shop.cart',true);
        if (!isset($cartSession->items)) {
            $cartSession->items = array();
        }
        
        Zend_Registry::set('Shop_Cart_Session',$cartSession);
    }
    
}
?>