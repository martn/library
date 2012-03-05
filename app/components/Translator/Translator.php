<?php

require_once LIBS_DIR . '/Zend/Translate.php';
require_once LIBS_DIR . '/Nette/ITranslator.php';

class MyTranslator extends Zend_Translate implements /*Nette\*/ITranslator
{
    

    public function __construct($locale) {
        parent::__construct('gettext', dirname(__FILE__).'/messages.mo', $locale);
    }
    
    
    /**
     * Translates the given string.
     * @param  string   message
     * @param  int      plural
     * @return string
     */
    public function translate($message, $plural = NULL)
    {
        return parent::translate($message);
    }
    
    
    public function process($msg) {
        return $this->translate($msg);
    }
}
