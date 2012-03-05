<?php
/**
 * DataViewBase abstract class, provides data view functionality in boxes filled with data tree
 * data = ArrayList(Tree(...), // first node contains box data 
 * 					...);
 * 	
 * 
 * @package Nette-components
 */
require_once COMPONENTS_DIR . '/Base/BaseControl.php';

abstract class DataViewBase extends BaseControl {

    /** @var class */
    protected $class;
    
    protected $data;
    
    protected static $GROUPS_NAMESPACE = 'groups';

    
    function setData(GroupList $data) {
        $this->data = $data;
        //print_r($data);
    }

    /**
     * funcion adds new box 
     * @return unknown_type
     */
/*    public function addGroup($name = '')
    {
        $this->addObject(new Hashtable(array('name'=>$name,
                                            'data'=> new ArrayList)),
                        self::$GROUPS_NAMESPACE);
        return $this;
    }
  */
    
    /**
    * @desc adds a row
    */
/*    public function addData($label, $data)
    {
        $this->getCurrent(self::$GROUPS_NAMESPACE)
                ->get('data')
                ->append(array('label' => $label,
                                'data' => $data));
        return $this;
    }
    */
    
    /**
    * @desc renders the table
    */
    public function render() {
        $template = $this->createTemplate();
        
        $template->data = $this->data;
        
        $template->setFile($this->getLayout());
        $template->render();
    }
    
    
    /**
     * returns layout file
     * @return string
     */
    abstract function getLayout();
}  

class UncorrectData extends Exception {
}
