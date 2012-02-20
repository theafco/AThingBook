<?php
class My_View_Helper_Address extends Zend_View_Helper_Abstract
{
    public function address(/*array*/$data) {
        $string = $data['address'] . ' ';
        $string .= (($data['province_code']==10)?'แขวง':'ตำบล') . $data['subdistrict'] . ' ';
        $string .= (($data['province_code']==10)?'เขต':'อำเภอ') . $data['district'] . ' ';
        $string .= 'จังหวัด' . My_Data_Province::getInstance()->getById($data['province_code']) . ' ';
        $string .= $data['zipcode'];
        return $string;
    }
}
?>