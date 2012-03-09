<?php
class My_View_Helper_Address extends Zend_View_Helper_Abstract
{
	/**
	 * Return full address
	 * @param array $address
	 * @return string
	 */
    public function address($address)
    {
        if (array_key_exists('address1', $address)) {
            $strAddress = $address['address1'] . ' ';
        } else {
            throw new Zend_Exception('Invalid parameters:address1');
        }
        
        if (array_key_exists('provincecode', $address)) {
            $provinceCode = $address['provincecode'];
        } else {
            throw new Zend_Exception('Invalid parameters:provincecode');
        }
        
        if (array_key_exists('subdistrict', $address)) {
        	$strAddress .= ( ($provinceCode == 10)?'แขวง':'ตำบล' ) . $address['subdistrict'] . ' ';
        } else {
            throw new Zend_Exception('Invalid parameters:subdistrict');
        }
        
        if (array_key_exists('district', $address)) {
        	$strAddress .= ( ($provinceCode == 10)?'เขต':'อำเภอ' ) . $address['district'] . ' ';
        } else {
        	throw new Zend_Exception('Invalid parameters:district');
        }
        
        $strAddress .= 'จังหวัด' . My_Data_Province::getInstance()->getById($provinceCode) . ' ';

        if (array_key_exists('district', $address)) {
        	$strAddress .= $address['zipcode'];
        } else {
        	throw new Zend_Exception('Invalid parameters:zipcode');
        }

        return $strAddress;
    }
    
}
?>