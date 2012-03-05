<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class GroupList extends Collection {

    private $current;

    function __construct() {
        parent::__construct();
    }

    function append($item) {
        if (!($item instanceof Group))
            throw new /* \ */InvalidArgumentException("Argument must be Group object.");

        parent::append($item);
    }

    /**
     * adds new group to the list
     * @param <type> $name
     * @return Group
     */
    function addGroup($name = '') {
        $this->current = new Group($name);
        $this->append($this->current);
        return $this->current;
    }
}
