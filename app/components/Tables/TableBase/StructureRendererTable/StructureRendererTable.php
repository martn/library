<?php

require_once dirname(__FILE__) . '/../ActionGeneratorTable.php';
require_once dirname(__FILE__) . '/../../IDataRenderer.php';

/**
 * @author martin
 *
 */
abstract class StructureRendererTable extends ActionGeneratorTable implements IDataRenderer {
    const RENDERER_BOOLEAN = 'customRenderBoolean';

    /**
     * data to render
     * @var IRenderableDataList|IRenderableDataTree
     */
    protected $data;
    protected $showHead = true;

    /**
     * data to view
     * @param IRenderableDataObject $data
     * @return unknown_type
     */
    function setData(IRenderableDataObject $data) {
        $this->data = $data;
        return $this;
    }

    /**
     * @param unknown_type $name
     * @param unknown_type $label
     * @return unknown
     */
    public function addColumn($name, $label) {
        $this->addObject(new Hashtable(array('name' => $name,
                    'label' => $label)),
                'columns');
        return $this;
    }

    /**
     * if set to true, no head is shown
     * @param boolean $showHead
     */
    function setShowHead($showHead = true) {
        $this->showHead = $showHead;
    }

    /**
     * sets renderer of current column
     * @param array|string $renderer
     * @return TableBase
     */
    public function setRenderer($renderer) {
        $this->getCurrent('columns')->add('renderer', $renderer);
        return $this;
    }


    protected function getRowTemplate() {
        return dirname(__FILE__) . '/row.phtml';
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/controls/Tables/IDataRenderer#renderItem($data)
     */
    function renderItem($data) {
        $template = $this->createTemplate();
        $template->setFile($this->getRowTemplate());

        $template->data = $data;
        $template->columns = $this->getObjects('columns');

        $template->actions = $this->getActionMenu($data);

        $template->render();
    }

    
    /**
     * renders cell by custom renderer
     * @param Traversable $data
     * @param HashTable $col
     * @return unknown_type
     */
    function renderCell($data, HashTable $col, NSmartCachingIterator $iterator) {
        if (isset($col['renderer'])) {
            $renderer = $col['renderer'];

            list($obj, $method) = is_array($renderer) ?
                    $renderer : array($this, $renderer);

            return $obj->$method($data->$col['name'], $data);
        } else {
            return $data->$col['name'];
        }
    }

    function renderBody() {
        $this->data->render($this);
    }

    function renderHead() {
        if ($this->showHead) {
            $template = $this->createTemplate();

            $template->setFile(dirname(__FILE__) . '/head.phtml');

            $template->columns = $this->getObjects('columns');

            $template->render();
        }
    }


    
    /**
     * custom cell renderer for boolean data
     * @param unknown_type $standardContent
     * @param Traversable $rowData
     * @return unknown_type
     */
    protected function customRenderBoolean($standardContent, Traversable $rowData) {
        return $standardContent ? "Ano" : "Ne";
    }

}

class NoActionsDefinedException extends TableException {

}

