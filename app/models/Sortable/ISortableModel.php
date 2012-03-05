<?php

require_once LIBS_DIR . '/MyLib/Model/IModel.php';

interface ISortableModel extends IModel {

    /**
     * @desc moves up selected item
     */
    public function moveUp($id);

    /**
     * @desc moves down selected item
     */
    public function moveDown($id);

    /**
     * @desc returns record which position is to be changed
     * (must containt 'ord' and 'id')
     * @return array, DibiRow
     */
    public function getSortableRecord($id);

    /**
     * @desc data source for ordering
     * @param id
     * @return DibiDataSource
     */
    public function getSortableDataSource($id);

    /**
     * @desc returns sortable table (contains ord and id)
     * @return string
     */
    public function getSortableTable();
}