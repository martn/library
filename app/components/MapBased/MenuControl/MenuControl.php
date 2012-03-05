<?php

require_once dirname(__FILE__) . '/../MapControl/MapControl.php';


class MenuControl extends MapControl {

	
   
    /**
    * @desc constructor
    */
    public function __construct() {
        parent::__construct();
        
    }
    

	
    
    /**
     * @desc sets layout
     */
    public function setLayout($layout)
    {
    	$this->layout = $layout;
    }
    


    /**
    * @desc prepares template for rendering with data
    * @param Template $template
    */
    protected function prepareTemplate()
    {
    	$template = $this->createTemplate();
    	
    	switch ($this->layout) {
    		case self::LAYOUT_MAINMENU:
    			$template->setFile(dirname(__FILE__) . '/mainmenu.phtml');
    			
				$template->data = $this->map->getChilds();    			
    		default:
    		break;
    	}
    	return $template;
    }
    
}
  
