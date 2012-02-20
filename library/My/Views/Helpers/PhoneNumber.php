<?php
class My_View_Helper_PhoneNumber extends Zend_View_Helper_Abstract
{
    
    public function phonenumber($phones) {
        if ($phones['home']) {
            $string = ' บ้าน: ' . $this->phoneformat($phones['home']);
        }
        if ($phones['mobile']) {
        	$string .= ' มือถือ: ' . $this->phoneformat($phones['mobile']);
        }
        return $string;
    }
    
    private function phoneformat($phone) {
    	$phone = preg_replace("/[^0-9]/", "", $phone);
   
    	if (strlen($phone) == 7) {
    		$string = preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
    	} elseif (strlen($phone) == 9) {
    		$string = preg_replace("/([0-9]{2})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
    	} elseif (strlen($phone) == 10) {
    		$string = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
    	} else {
    		$string = $phone;
    	}
    
    	return $string;
    }
}
?>