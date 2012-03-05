<?php

/**
 * class implementing IRenderableDataList, to be used for rendering list data
 */
require_once dirname(__FILE__) . '/../IRenderableGroupTree.php';
require_once LIBS_DIR . '/Nette/Object.php';

/**
 * @author martin
 *
 */
class GroupTree extends Object implements IRenderableGroupTree {

    protected $trees;
    protected $renderer;
    private $current;

    public function __construct() {
        $this->trees = new ArrayList();
    }

    public function addTree(Tree $tree, $data) {
        $tree->addMultipleData($data);
        $this->trees->append($tree);

        $this->setCurrent($tree);
    }

    private function setCurrent(DataTree $current) {
        return $this->current = $current;
    }

    
    function setRenderer(IDataRenderer $renderer) {
        $this->renderer = $renderer;
    }

    function getCurrentTree() {
        return $this->current;
    }

    function render(IDataRenderer $renderer = NULL) {
        if ($renderer !== NULL)
            $this->setRenderer($renderer);

        foreach ($this->trees as $tree) {
            $this->renderer->renderItem($tree);
        }
    }

}