<?php

/**
 * @desc class provides Tree functionality based on data from given Model
 */
require_once LIBS_DIR . '/MyLib/Collections/Tree.php';
require_once dirname(__FILE__) . '/../IRenderableDataTree.php';

/**
 * @author martin
 *
 */
class DataTree extends Tree implements IRenderableDataTree {

    protected $dataModel;
    protected $level = 0;
    protected $renderer;
    

    public function __construct(ITreeModel $model, $data = NULL) {
        parent::__construct();
        $this->setModel($model);

        $bindId = empty($data) ? NULL : $data->id;

        $this->addMultipleData($data);

        foreach ($model->getChilds($bindId) as $child) {
            $this->appendChild(new self($this->getModel(), $child));
        }
    }

    /* (non-PHPdoc)
     * @see scripts/app/models/DataStructures/IRenderableDataList#setRenderer($renderer)
     */

    function setRenderer(IDataRenderer $renderer) {
        $this->renderer = $renderer;
    }

    /* (non-PHPdoc)
     * @see scripts/app/models/DataStructures/IRenderableDataStructure#render($renderer)
     */

    function render(IDataRenderer $renderer = NULL) {
        if ($renderer !== NULL)
            $this->setRenderer($renderer);

        foreach ($this->getChilds() as $child)
            $child->renderInternal($this->renderer);
    }

    /**
     * internal render function
     * @param IDataTreeRenderer $renderer
     * @param integer $level
     * @return unknown_type
     */
    public function renderInternal(IDataRenderer $renderer, $level = 0) {
        $this->setLevel($level);
        $renderer->renderItem($this);

        foreach ($this->getChilds() as $child) {
            $child->renderInternal($renderer, $level + 1);
        }
    }

    function getLevel() {
        return $this->level;
    }

    /**
     * sets level in the hierarchy list;
     * @param unknown_type $level
     */
    function setLevel($level) {
        $this->level = $level;
    }

    /**
     * sets data model
     * @param $model
     * @return unknown_type
     */
    public function setModel(ITreeModel $model) {
        $this->dataModel = $model;
    }

    /**
     * returns dataModel
     * @return ITreeModel
     */
    public function getModel() {
        return $this->dataModel;
    }

    /**
     * @desc returns object id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * returns form array from tree
     * @param array $array
     * @param string $key
     * @param string $val
     * @param mixed $cutKey
     * @param integer $level
     * @return array
     */
    public function getFormArray($cutKey = null, $val = 'name', $key = 'id', array $array = null, $level = 0) {
        if (empty($array))
            $array = Utils::addEmptyRowToArray(array());

        return $this->getFormArrayBody($this, $cutKey, $val, $key, $array, $level);
    }

    /**
     * recursive body of getFormArray function
     * @param unknown_type $cutKey
     * @param unknown_type $val
     * @param unknown_type $key
     * @param array $array
     * @param unknown_type $level
     * @return unknown_type
     */
    private function getFormArrayBody(DataTree $object, $cutKey, $val, $key, array $array, $level) {
        foreach ($object->getChilds() as $child) {
            if ($child->$key !== $cutKey) {
                $array[$child->$key] = str_repeat("...", $level) . " " . $child->$val;

                $array = $this->getFormArrayBody($child, $cutKey, $val, $key, $array, $level + 1);
            }
        }

        return $array;
    }

    /**
     * @desc returns object name
     */
    public function getName() {
        return $this->name;
    }

}