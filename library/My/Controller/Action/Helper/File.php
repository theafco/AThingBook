<?php
class My_Controller_Action_Helper_File extends Zend_Controller_Action_Helper_Abstract
{
    public function getExtension($filename) {
        if(filename) {
	        $ext = split("[/\\.]", $filename) ;
	        $n = count($ext)-1;
	        $ext = $ext[$n];
	        }
        return $ext;
    }
}
?>