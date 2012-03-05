<?php

require_once LIBS_DIR . '/Nette/Utils/Object.php';

class DataSorter extends NObject {
    const ORDER_STEP = 5;

    private $model;

    public function __construct(ISortableModel $model) {
        $this->model = $model;
    }

    /**
     * @desc direction = -1 or +1
     */
    private function changeOrderBody($id, $direction) {
        try {
            $data = $this->model->getSortableRecord($id);

            $this->updateOrder($id, $data['ord'] + $direction * self::ORDER_STEP + $direction);

            $this->reOrder($id);
        } catch (NotFoundException $e) {
            throw $e;
        }
    }

    
    /**
     * @desc updates ordering according to given id and ord,
     * uses getSortableTable
     * @param unknown_type $id
     * @param unknown_type $ord
     * @return unknown_type
     */
    private function updateOrder($id, $ord) {
        return dibi::update($this->model->getSortableTable(), array('ord' => $ord))
                ->where('id=%i', $id)
                ->execute();
    }

    
    /**
     * @desc moves up selected item
     */
    public function moveUp($id) {
        $this->changeOrderBody($id, -1);
    }

    
    /**
     * @desc moves down selected item
     */
    public function moveDown($id) {
        $this->changeOrderBody($id, 1);
    }


    /**
     * @desc reorders group acc to some id from the group
     */
    public function reOrder($some_id) {
        try {
            $ord = 2 * self::ORDER_STEP;

            foreach ($this->model->getSortableDataSource($some_id) as $item) {

                $this->updateOrder($item->id, $ord);
                $ord += self::ORDER_STEP;
            }
        } catch (NotFoundException $e) {
            throw $e;
        }
    }

}
