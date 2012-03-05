<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once LIBS_DIR . '/Nette/Utils/Object.php';

/**
 * Description of DataGroup
 *
 * @author martin
 */
class GroupData extends NObject {

    private $data;
    private $dataSource;

    function __construct($data, $dataSource) {
        $this->data = $data;
        $this->dataSource = $dataSource;
    }

    public function getData() {
        return $this->data;
    }

    public function getDataSource() {
        return $this->dataSource;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setDataSource($dataSource) {
        $this->dataSource = $dataSource;
    }

}
