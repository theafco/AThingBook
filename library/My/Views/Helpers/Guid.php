<?php
class My_View_Helper_Guid extends Zend_View_Helper_Abstract
{

    public function guid($format='B')
    {
        $guid = com_create_guid();
        /*
         * 	N
			32 digits:
			00000000000000000000000000000000
			D
			32 digits separated by hyphens:
			00000000-0000-0000-0000-000000000000
			B
			32 digits separated by hyphens, enclosed in braces:
			{00000000-0000-0000-0000-000000000000}
			P
			32 digits separated by hyphens, enclosed in parentheses:
			(00000000-0000-0000-0000-000000000000)
			X
			Four hexadecimal values enclosed in braces, where the fourth value is a subset of eight hexadecimal values that is also enclosed in braces:
			{0x00000000,0x0000,0x0000,{0x00,0x00,0x00,0x00,0x00,0x00,0x00,0x00}}
         */
        switch ($format) {
        	case 'N':
        		$guid = str_replace(array('{','}','-'), null, $guid);
        		break;
        }
        return $guid;
    }
}
?>