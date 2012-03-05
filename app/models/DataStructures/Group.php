<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * Description of DataGroup
 *
 * @author martin
 */
class Group extends ArrayList {

    private $name;

    function __construct($name = '') {
        parent::__construct();
        $this->name = $name;
    }

    function append($item) {
        throw new DeprecatedException();
    }

    public function getName() {
        return $this->name;
    }

    public function addData($data, $label = '') {
        parent::append(array('label' => $label,
                              'data' => $data));
    }
}