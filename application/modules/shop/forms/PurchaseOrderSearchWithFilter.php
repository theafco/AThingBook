<?php

class Shop_Form_PurchaseOrderSearchWithFilter extends Application_Form_Search
{

    public function init()
    {
    	parent::init();

		$this->searchBy->setMultiOptions(array(
			'id'=>'เลขที่ใบสั่งซื้อ',
		));

		$byStatus = new Zend_Form_Element_Select('status',array(
			'label'		=>	'สถานะ',
			'dojoType'	=>	'dijit.form.Select',
			'multioptions'	=>	array(
									''	=>	'ทุกสถานะ',
								),
		));
		
		$statusModel = new Model_PurchaseOrderStatus();
		$status = $statusModel->findAll()->toKeyValueArray('id', 'name');
		$byStatus->addMultiOptions($status);

		$this->addElements(array($byStatus));
		
		$this->addSubmitButton();
    }

}

