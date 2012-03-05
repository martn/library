<?php

require_once dirname(__FILE__) . '/../MapControl/MapControl.php';


class NavigatorControl extends MapControl {
    
   
    /**
    * @desc constructor
    */
    public function __construct() {
        parent::__construct();
    }
    

    /**
    * @desc prepares template for rendering with data
    * @param Template $template
    */
    protected function prepareTemplate()
    {
    	$template = $this->createTemplate();
    	$template->setFile(dirname(__FILE__) . '/template.phtml');
       	$template->data = $this->data;
       	return $template;
    }
}
  
