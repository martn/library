<?php

require_once COMPONENTS_DIR . '/Base/StorageControl.php';
//require_once dirname(__FILE__) . '/ISetTable.php';

/**
 * @author martin
 *
 */
abstract class TableBase extends StorageControl {

    /** @var oddRows */
    private $rowNumber = 0;
    public $paginator = false;
 
    /**
     *
     * @return unknown_type
     */
    public function paginatorOn() {
        $this->paginator = true;
    }


    /**
     * @desc object constructor
     */
    public function __construct(IComponentContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);

        $this->setHtmlClass('tableSet');
    }

    /**
     * @desc renders the table body
     */
    abstract function renderBody();

    /**
     * @desc renders head of the table 
     */
    abstract function renderHead();

    /**
     * returns new row number
     * @return unknown_type
     */
    public function getRowNumber() {
        return $this->rowNumber = 1 - $this->rowNumber;
    }

    /**
     * renders begining
     * @return unknown_type
     */
    public function render() {
        $template = $this->createTemplate();

        $template->setFile($this->getLayout());

        $template->render();
    }

    /**
     * returns basic layout
     */
    protected function getLayout() {
        return dirname(__FILE__) . '/table.phtml';
    }

    
    
    /**
     * @desc returns Paginator from component visualPaginator
     * @return Paginator
     */
    protected function getPaginator() {
        return $this->getComponent('vp')->getPaginator();
    }
    
    
    protected function createComponent($name) {
        switch ($name) {
            case 'vp':
                $vp = new VisualPaginator($this, $name);
                $p = $vp->getPaginator();
                $p->setItemsPerPage($this->getItemsPerPage());
                return;
            default:
                parent::createComponent($name);
                return;
        }
    }
    
}

abstract class TableException extends Exception {

}
