<?php

/**
 * TODO: include paginator, filters....
 */
require_once dirname(__FILE__) . '/../ListTable/ListTable.php';

class DsTable extends ListTable {

    private $ds;


    const ITEMS_PER_PAGE = 20;


 

    public function handleSetOrder($col) {
        $this->setOrderBy($col, $this->getPresenter()->getAction(true));
    }



    public function setDataSource(DibiDataSource $ds) {
        $this->setData(new DataList($ds));

        $this->ds = $ds;
        //return $this->ds;

        $this->paginatorPrepare();
        try {
            $ord = $this->getOrderBy($this->getPresenter()->getAction(true));

            $this->ds->orderBy($ord[0], $ord[1]);
        } catch (NotFoundException $e) {
            //throw()
        }

        return $this;
    }

    /**
     * @desc prepares paginator and applies limits on datasource
     * @param DibiDataSource $ds
     * @return unknown_type
     */
    private function paginatorPrepare() {
        if (empty($this->ds)) {
            throw new NoDataSourceException();
        }

        $this->getPaginator()->setItemCount($this->ds->count());

        $this->ds->applyLimit($this->getPaginator()->getLength(),
                $this->getPaginator()->getOffset());
    }

    /**
     * @desc returns stored number of items per page or default number if nothing stored;
     * @return unknown_type
     */
    protected function getItemsPerPage() {
        try {
            return $this->loadVariable('itemsPerPage', $this->getPresenter()->getAction(true));
        } catch (NotFoundException $e) {

            return self::ITEMS_PER_PAGE;
        }
    }

    public function addColumn($name, $label, $order = false) {
        if ($order)
            $label = NHtml::el('a')->href($this->link('setOrder', $name))->setText($label);

        return parent::addColumn($name, $label);
    }

    /**
     * @desc stores number of items per page
     * @return unknown_type
     */
    protected function setItemsPerPage($number) {

        return $this->saveVariable('itemsPerPage', $number, $this->getPresenter()->getAction(true));
    }

    /**
     * @desc new form handle
     */
    public function formItemsPerPageSubmitted(Form $form) {
        $data = $form->getValues();

        $this->setItemsPerPage($data['number']);
        $this->flashMessage($this->getItemsPerPage());
    }

    

    /**
     * @desc additional template process
     * @return unknown_type
     */
    function beforeRender(Template $template) {

        $template->paginator = $this->paginator;
        if ($this->paginator) {
            $template->formItemsPerPage = $this->getComponent('formItemsPerPage');
            $template->formItemsPerPage->setDefaults(array('number' => $this->getItemsPerPage()));
        }
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/controls/Tables/SetTable/ISetTable#getRowDataLayout()
     */
    function getRowDataLayout() {
        return dirname(__FILE__) . '/rowData.phtml';
    }

    protected function createComponent($name) {
        switch ($name) {
            case 'formItemsPerPage':
                $form = new MyForm($this, $name);


                $form->addSelect('number', 'stránkování', array(5 => '5', 10 => '10',
                            20 => '20',
                            50 => '50',
                            100 => '100'))
                        ->getControlPrototype()->onchange('submit()');

                $form->onSubmit[] = array($this, 'formItemsPerPageSubmitted');

                return;
            
            default:
                parent::createComponent($name);
                return;
        }
    }

}

class NoDataSourceException extends TableException {

}
