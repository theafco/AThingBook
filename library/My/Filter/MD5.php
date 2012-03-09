<?php
class My_Filter_MD5 implements Zend_Filter_Interface
{
    public function filter($value)
    {
        if (!empty($value)) {
            return md5($value);
        }
       
    }
}
?>