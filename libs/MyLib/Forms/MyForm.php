<?php
/**
 * MyLib
 *
 * @copyright  Copyright (c) 2010 Martin Novák
 * @category   MyLib
 * @package    MyLib
 */


require_once dirname(__FILE__) . '/AdvancedForm.php';


/**
 * Advanced Form 
 *
 * @copyright  Copyright (c) 2010 Martin Novák
 * @package    MyLib
 * @author 	   Martin Novák	
 *
 */
class MyForm extends AdvancedForm {


	/**
     * Application form constructor.
     */
    public function __construct(IComponentContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        
        $this->mySettings();
    }


    
    /**
    * @desc some additional settings    
    */
    private function mySettings() {
        //$this->setTranslator(new Translator($this->getParent()->getLang(),LOCALE_DIR));

        
        $renderer = $this->getRenderer();
        // budeme generovat formulář jako definiční seznam
        $renderer->wrappers['form']['container'] = NHtml::el('div class=myform');
        $renderer->wrappers['controls']['container'] = 'dl';
        $renderer->wrappers['pair']['container'] = NHtml::el('div class=input_pair');
        $renderer->wrappers['label']['container'] = 'dt';
        $renderer->wrappers['control']['container'] = 'dd';
        
    }
}
