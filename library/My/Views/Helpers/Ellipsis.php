<?php
class My_View_Helper_Ellipsis extends Zend_View_Helper_Abstract
{
    public function ellipsis($text,$length = 255,$ending = "...")
    {
        if (empty($length)) {
            $length = 255;
        }
        if(empty($ending)) {
            $ending = "...";
        }
        $text = strip_tags($text);
        if (strlen($text) > $length) {
            $ellipsis = substr($text,0,$length-1) . $ending;
        } else {
            $ellipsis = $text;
        }
        return trim($ellipsis);
    }
}
?>