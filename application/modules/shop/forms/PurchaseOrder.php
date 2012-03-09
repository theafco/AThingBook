<?php
class Shop_Form_PurchaseOrder extends Application_Form_Editor
{

	public function init()
	{

		parent::init();
		$statusModel = new Model_PurchaseOrderStatus();

		$status = new Zend_Form_Element_Select('status_id',array(
				'label'		=>	'สถานะใบสั่งซื้อ',
				'required'	=>	true,
				'multiOptions'	=> $statusModel->findAll()->toKeyValueArray('id', 'name'),
		));
		$status->setAttribs(array(
				'dojoType'	=>	'dijit.form.Select',
		));
		$this->_dojoHelper->dojo()->requireModule(array('dijit.form.Select'));

		$this->addElements(array(
				$status,
		));

		$this->addSubmitButton();
	}

}
