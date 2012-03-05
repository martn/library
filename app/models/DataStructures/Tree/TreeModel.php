<?php

require_once MODELS_DIR . '/Base/BaseModel.php';
require_once dirname(__FILE__) . '/ITreeModel.php';

abstract class TreeModel extends BaseModel implements ITreeModel {

    protected $tree;

    /**
     * returns tree from database
     * @return DataTree
     */
    public function getTree() {
        if (empty($this->tree))
            $this->tree = new DataTree($this);

        return $this->tree;
    }

    
    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Tree/ITreeModel#getParent($id)
     */
    public function getParent($id) {
        $parentId = dibi::select('parent_id')
                        ->from($this->getTable())
                        ->where('id=%i', $id)
                        ->fetchSingle();

        if($parentId === NULL) {
            throw new NotFoundException();
        } else {
            return $this->find($parentId);
        }
    }


     /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#insert($args)
     */
    public function insert(array $args, $table = null) {
        // NULL FIX
        if(!is_numeric($args['parent_id'])) $args['parent_id'] = NULL;
        return parent::insert($args, $table);
    }



    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#insert($args)
     */
    public function update(array $args, $table = null) {
        // NULL FIX hack
        if(!is_numeric($args['parent_id'])) $args['parent_id'] = NULL;
        return parent::update($args, $table);
    }



    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Tree/ITreeModel#getChilds($parent_id)
     */
    public function getChilds($id = NULL) {
        return $this->dataSource($id, 'parent_id', $id === NULL ? NULL : 'i');
    }

    /**
     * returns count of children
     * @param unknown_type $id
     */
    function countChilds($id) {
        return $this->getChilds($id)->count();
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#delete($id, $table)
     */
    /* 	public function delete($id, $table = null)
      {
      foreach($this->getChilds($id) as $child) {
      $this->delete($child->id);
      }
      parent::delete($id);
      } */

    /**
     * returns true if item has no parent,
     * throws NotFoundException if no item of given id exists
     * @param integer $id
     * @return boolean
     */
    public function isRoot($id) {
        return $this->find($id)->parent_id == 0 ? true : false;
    }

}
