<?php
class Application_Form_Editor extends Application_Form_FormBase
{
    Private $_submitButton;
    
    public function init()
    {
        parent::init();

        $this->_submitButton = $this->send;
        $this->_submitButton
        		->setName('save')
        		->setAttrib('label','บันทึก');

        $this->removeElement('send');

        $this	->setAttrib('id', 'editorForm');
		        
    }
    
    public function addSubmitButton()
    {
        $this	->addElement($this->_submitButton)
		        ->addElement(new Zend_Dojo_Form_Element_Button('cancel',array('label'=>'ยกเลิก')));
    }
}
?>