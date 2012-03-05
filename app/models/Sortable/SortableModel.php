<?php

require_once dirname(__FILE__) . '/ISortableModel.php';
require_once MODELS_DIR . '/Base/BaseModel.php';

abstract class SortableModel extends BaseModel implements ISortableModel {

    private $sorter;

    public function __construct() {
        parent::__construct();

        $this->sorter = new DataSorter($this);
    }

    public function getSorter() {
        return $this->sorter;
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Sortable/ISortableModel#getSortableTable()
     */
    public function getSortableTable() {
        return $this->getTable();
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Sortable/ISortableModel#getSortableTable()
     */
    function getSortableRecord($id) {
        return $this->find($id);
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Sortable/ISortableModel#getSortableDataSource($id)
     */
    function getSortableDataSource($id) {
        return $this->dataSource();
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#dataSource($value, $column, $context, $table)
     */
    public function dataSource($value = null, $column = 'id', $context = 'i', $table = null) {
        return parent::dataSource($value, $column, $context, $table)->orderBy('ord');
    }

    public function processMoveUp($args) {
        return $this->moveUp($args['id']);
    }

    public function processMoveDown($args) {
        return $this->moveDown($args['id']);
    }

    /**
     * @desc moves up selected item
     */
    public function moveUp($id) {
        $this->getSorter()->moveUp($id);
        $this->reOrder($id);
    }

     /**
     * @desc moves down selected item
     */
    public function moveDown($id) {
        $this->getSorter()->moveDown($id);
        $this->reOrder($id);
    }


    
    function placeBefore($movingId, $staticId) {
        $this->update(array('id' => $movingId,
            'ord' => $this->find($staticId)->ord - DataSorter::ORDER_STEP / 2),
                $this->getSortableTable());

        $this->reOrder($movingId);
    }

   

    function insert(array $args, $table = null) {
        $id = parent::insert($args, $table);
        $this->reOrder($id);
        return $id;
    }

    /**
     * @desc reorders group acc to some id from the group
     */
    public function reOrder($some_id) {
        $this->sorter->reOrder($some_id);
    }

}
