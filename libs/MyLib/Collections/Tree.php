<?php

/**
 * @desc class to provide tree functionality
 */
require_once LIBS_DIR . '/Nette/Utils/Object.php';

class Tree extends NObject {

    protected $childs;
    protected $data;
    protected $parent;
    protected $lastChild;

    public function __construct() {
        $this->childs = new ArrayList();
        $this->parent = null;
        $this->data = new Hashtable();
        $this->lastChild = null;
    }

    /**
     * @desc returns true if the object is a root
     */
    public function isRoot() {
        return $this->parent === NULL ? true : false;
    }

    /**
     * @desc returns root element of the tree
     */
    public function getRoot() {
        return $this->isRoot() ? $this : $this->getParent()->getRoot();
    }

    /**
     * @desc appends new Tree object as child
     */
    public function appendChild(Tree $child) {
        $child->setParent($this);
        $this->childs->append($child);
        $this->lastChild = $child;
    }

    /**
     * @desc removes child of defined offset
     */
    public function removeChild($item) {
        $this->childs->remove($item);
        //$this->childs->offsetUnset($offset);
    }

    /**
     * @desc returns last inserted child
     */
    public function lastChild() {
        return $this->lastChild;
    }

    /**
     * @desc sets a parent Tree object
     */
    public function setParent(Tree $parent) {
        $this->parent = $parent;
    }

    /**
     * @desc returns parent object
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @desc returns number of childs
     */
    public function countChilds() {
        return $this->childs->count();
    }

    /**
     * @desc retuns ArrayList of all childs
     */
    public function getChilds() {
        return $this->childs;
    }

    /**
     * @desc counts all data items
     */
    public function count() {
        return $this->data->count();
    }

    /**
     * @desc returns data object
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @desc appends data item or items (if Traversable) to the data array (hash table)
     */
    public function addData($value) {
        //if (!(is_array($data) || $data instanceof Traversable)) {
        $this->addDataAt('' . $this->count(), $value);
    }

    /**
     * @desc add more data - Traversable
     */
    public function addMultipleData($data) {
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $this->addDataAt($key, $val);
                //$this->data[$key] = $val;
            }
        }
    }

    /**
     * @desc appends data on specified hash key
     */
    public function addDataAt($key, $val) {
        $this->data->offsetSet($key, $val);
    }

    /**
     * Returns data value.
     * @param  string  property name
     * @return mixed
     */
    public function &__get($key) {
        $d = $this->data->get($key);
        return $d;
    }

    /**
     * @desc sets internal data value
     */
    public function __set($key, $val) {
        $this->data->offsetSet($key, $val);
    }

}
