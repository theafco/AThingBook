<?php
class Zend_Dojo_View_Helper_Select extends Zend_Dojo_View_Helper_ComboBox
{
    /**
     * Dijit being used
     * @var string
     */
    protected $_dijit  = 'dijit.form.Select';

    /**
     * Dojo module to use
     * @var string
     */
    protected $_module = 'dijit.form.Select';

    /**
     * dijit.form.FilteringSelect
     *
     * @param  int $id
     * @param  mixed $value
     * @param  array $params  Parameters to use for dijit creation
     * @param  array $attribs HTML attributes
     * @param  array|null $options Select options
     * @return string
     */
    public function select($id, $value = null, array $params = array(), array $attribs = array(), array $options = null)
    {
        return $this->comboBox($id, $value, $params, $attribs, $options);
    }
}
