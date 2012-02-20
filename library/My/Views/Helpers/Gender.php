<?php
class My_View_Helper_Gender extends Zend_View_Helper_Abstract
{
    public function gender($value)
    {
        switch ($value) {
        	case 'm':
        	    $string = 'ชาย';
        	  	break;
        	case 'f':
        	    $string = 'หญิง';
        	    break;
        	default:
        	    $string = false;
        }
        return $string;
    }
}
?>