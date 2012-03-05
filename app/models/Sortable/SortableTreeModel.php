<?php

require_once MODELS_DIR . '/DataStructures/Tree/TreeModel.php';
require_once dirname(__FILE__) . '/ISortableModel.php';

abstract class SortableTreeModel extends TreeModel implements ISortableModel {

    private $sorter;

    public function __construct() {
        parent::__construct();

        $this->sorter = new DataSorter($this);
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#dataSource($value, $column, $context, $table)
     */
    public function dataSource($value = null, $column = 'id', $context = 'i', $table = null) {
        return parent::dataSource($value, $column, $context, $table)->orderBy('ord');
    }

    /**
     * @desc moves up selected item
     */
    public function moveUp($id) {
        $this->sorter->moveUp($id);
    }

    /**
     * @desc moves down selected item
     */
    public function moveDown($id) {
        $this->sorter->moveDown($id);
    }


    function processMoveUp($itemId) {
        $this->moveUp($itemId);
    }

    function processMoveDown($itemId) {
        $this->moveDown($itemId);
    }

    
    function  insert(array $args, $table = null) {
        $id = parent::insert($args, $table);
        $this->reOrder($id);
        return $id;
    }

    
    function delete($id, $table = null) {
        $ordId = NULL;

        foreach($this->getChilds($this->find($id)->parent_id) as $sibling) {
            $ordId = $sibling->id == $id ? NULL : $sibling->id;
        }

        $retval = parent::delete($id, $table);

        echo "ordId: ".$ordId;
        if($ordId) $this->reOrder ($ordId);

        return $retval;
    }


    /**
     * @desc reorders group acc to some id from the group
     */
    public function reOrder($some_id) {
        $this->sorter->reOrder($some_id);

        foreach ($this->getChilds($some_id) as $child) {
            $this->reOrder($child->id);
            break;
        }
    }

}
