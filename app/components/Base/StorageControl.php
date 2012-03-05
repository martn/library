<?php

require_once COMPONENTS_DIR . '/Base/BaseControl.php';

/**
 * @author martin
 *
 */
abstract class StorageControl extends BaseControl {

    private $data;
    private $current;

    public function __construct(IComponentContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);
        $this->reset();
    }

    /**
     * adds object to internal array
     * @param mixed $object
     * @return mixed
     */
    protected function addObject($object, $nameSpace = 'default') {
        $this->getStorage($nameSpace)->append($this->setCurrent($object, $nameSpace));
        return $this->getCurrent($nameSpace);
    }

    /**
     * returns named storage
     * @param string $nameSpace
     * @return unknown_type
     */
    private function getStorage($nameSpace) {
        if (!$this->data->offsetExists($nameSpace))
            $this->data->add($nameSpace, new ArrayList());

        return $this->data->get($nameSpace);
    }

    /**
     * resets all data
     * @return unknown_type
     */
    protected function reset() {
        $this->data = new Hashtable();
        $this->current = new Hashtable();
    }

    /**
     * returns ArrayList of objects
     * @return ArrayList
     */
    protected function getObjects($nameSpace = 'default') {
        return $this->getStorage($nameSpace);
    }

    /**
     * returns number of objects
     * @return integer
     */
    protected function countObjects($nameSpace = 'default') {
        return $this->getStorage($nameSpace)->count();
    }

    /**
     * returns current object
     * @return mixed
     */
    protected function getCurrent($nameSpace = 'default') {
        try {
            return $this->current->get($nameSpace);
        } catch (Exception $e) {
            throw new StorageEmptyException();
        }
    }

    /**
     * sets current object
     * @param mixed $object
     * @return unknown_type
     */
    private function setCurrent($object, $nameSpace = 'default') {
        try {
            $this->current->offsetSet($nameSpace, $object);
        } catch (KeyNotFoundException $e) {

            $this->current->add($nameSpace, $object);
        }
        return $object;
    }

}

class StorageEmptyException extends Exception {

}
