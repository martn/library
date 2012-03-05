<?php

/**
 * MyLib
 *
 * @copyright  Copyright (c) 2010 Martin Novák
 * @category   MyLib
 * @package    MyLib
 */
require_once LIBS_DIR . '/Nette/Application/AppForm.php';

/**
 * Advanced Form 
 *
 * @copyright  Copyright (c) 2010 Martin Novák
 * @package    MyLib
 * @author 	   Martin Novák	
 *
 */
class AdvancedForm extends NAppForm {
    const ADDITIONAL_HTML = 'additionalHtml';


    /**
     * handle method
     * @var string
     */
    protected $handle;
    protected $model;

    /**
     * Application form constructor.
     */
    public function __construct(IComponentContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);

        $this->setRenderer(new AdvancedRenderer());
    }

    /**
     * sets handle method for form postprocessing
     * @param $handle
     * @return Form
     */
    public function setHandle($model, $handle) {
        $this->handle = $handle;
        $this->model = $model;
        return $this;
    }

    /**
     * gets handle method for form postprocessing
     * @return string
     */
    public function getHandle() {
        return $this->handle;
    }

    public function getModel() {
        return $this->model;
    }

    /**
     * saves submitted form 
     */
    public function save() {
        if ($this->isSubmitted()) {
            return $this->toAction()->execute();
        } else {
            throw new FormStateErrorException();
        }
    }

    /**
     * generates Action 
     * @return Action  
     */
    public function toAction() {
        return new Action($this->getHandle(), $this->getModel(), $this->getValues());
    }

    /**
     * Adds Html content to the FormControl element (such as quick help)
     * @param IFormControl $control
     * @param Html $element
     * @return IFormControl
     */
    public function addHtml(IFormControl $control, NHtml $element) {
        $actualContent = $control->getOption(self::ADDITIONAL_HTML, null);

        if ($actualContent === null)
            $actualContent = array();

        array_push($actualContent, $element);

        $control->setOption(self::ADDITIONAL_HTML, $actualContent);
        return $control;
    }

    /**
     * Adds quick help to the given control
     * @param IFormControl $control
     * @param text $text
     * @return IFormControl
     */
    public function addQuickHelp(IFormControl $control, $text) {
        return $this->addHtml($control, NHtml::el('span')->class('tooltip')->title($text)->setText('?'));
    }

}

class FormStateErrorException extends Exception {

}
