<?php
class My_Form_Decorator_ErrorsHtmlTag extends Zend_Form_Decorator_Label
{
    protected $_placement = 'APPEND';

    public function render($content) {
        $element = $this->getElement();
        $view = $element->getView();
        if (null === $view) {
            return $content;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $tag = $this->getTag();
        $tagClass = $this->getTagClass();
        $id = $element->getId();

        $errors = $element->getMessages();
        if (!empty($errors)) {
            $errors = $view->formErrors($errors, $this->getOptions());
        } else {
            $errors = '';
        }

        if (null !== $tag) {
            $decorator = new Zend_Form_Decorator_HtmlTag();
            if (null !== $tagClass) {
                $decorator->setOptions(array(
                    'tag' => $tag,
                    'id' => $id . '-errors',
                    'class' => $tagClass));
            } else {
                $decorator->setOptions(array(
                    'tag' => $tag,
                    'id' => $id . '-errors'));
            }
            $errors = $decorator->render($errors);
        }

        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $errors;
            case self::PREPEND:
                return $errors . $separator . $content;
        }
    }
}