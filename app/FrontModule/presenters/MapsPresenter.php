<?php

require_once dirname(__FILE__) . '/Base/MapsBasePresenter.php';

final class Front_MapsPresenter extends Front_MapsBasePresenter {


	
    public function startup() {
        parent::startup();

        $this->model = $this->modelMaps;
        $this->modelMItems = $this->modelMapItems;

        if(!empty($this->id)) $this->modelMItems->setMapId($this->id);
    }
    
    
    
    /**
     * @desc returns some text
     * @param unknown_type $item
     * @return string
     */
    protected function getText($item)
    {
    	switch ($item) {
    		case self::TEXT_NEWITEM:
    		 	return 'vytvořit novou mapu';
    		case self::TEXT_CONFIRMDELETEITEM:
    		 	return 'Opravdu chcete smazat mapu '; 
    		default:
    		return "";
    	}	
    }
   
}
    