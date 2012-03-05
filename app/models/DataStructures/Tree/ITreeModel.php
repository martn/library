<?php

require_once LIBS_DIR.'/MyLib/Model/IModel.php';

interface ITreeModel extends IModel {
    
    
    /**
    * @desc returns parent record
    * @param integer $id
    * @throws NotFoundException
    */
    function getParent($id);
    
    
   /**
    * returns children records according to parent id
    * @param integer $parent_id
    * @return DibiDataSource
    */
    function getChilds($id = NULL);
    
    
    /**
     * returns count of childs
     * @param integer $id
     */
    function countChilds($id);
    
}