<?php

require_once dirname(__FILE__) . '/TreeBasePresenter.php';

abstract class Front_MapsBasePresenter extends Front_BasePresenter {

    //const

    protected $itemId = null;
    protected $modelMItems;

    const TEXT_NEWITEM = 0;
    const TEXT_CONFIRMDELETEITEM = 1;

    /**
     * @desc handles delete signal
     */
    public function handleMoveUp($itemId) {
        $this->setActionModel($this->modelMItems);
        $this->signalHandle();
    }

    /**
     * @desc handles delete signal
     */
    public function handleMoveDown($itemId) {
        $this->setActionModel($this->modelMItems);
        $this->signalHandle();
    }

    /**
     * @desc handles delete signal
     * TODO: inspect deleting whole map
     */
    public function handleDeleteItem($itemId) {
        $this->setActionModel($this->modelMItems);
        $this->signalHandle("Položka byla smazána.");
    }

    /**
     * @desc handles delete signal
     */
    public function handleDelete($id) {
        $this->signalHandle("Mapa byla smazána.");
    }

    /**
     * @desc edit stage
     */
    public function renderEdit($id) {
        $this->getComponent('formEdit')->setDefaults($this->model->find($id));
    }

    function actionNewItem($id, $parentId) {
        $this->actionCheck(new WebAction($this->getAction(), $this->modelMItems, $this, array('parentId' => $parentId)));
        $this->actionCheck(new WebAction('edit', $this->model, $this, array('id' => $id)));
    }

    function actionEditItem($itemId) {
        $this->actionCheck(new WebAction($this->getAction(), $this->modelMItems, $this, array('itemId' => $itemId)));
    }

    /**
     * @desc edit stage
     */
    public function renderNewItem($id, $parentId) {
        $this->getComponent('formNewItem')->setDefaults(array('parent_id' => $parentId));
    }

    /**
     * @desc edit stage
     */
    public function renderEditItem($itemId) {
        $this->getComponent('formEditItem')->setDefaults($this->modelMItems->find($itemId));
    }

    /**
     * @desc edit stage
     */
    public function renderNew() {
        $this->addTitle("Nová Mapa");
    }

    public function renderDefault() {
        $this->addTitle("Mapy");
    }

    /**
     * @desc new form handle
     */
    public function formItemSubmitted(NSubmitButton $button) {
        return $this->standardFormSubmitted($button, "Položka byla uložena.", "edit");
    }

    /**
     * @desc new form handle
     */
    public function formItemCanceled(NSubmitButton $button) {
        $this->redirect('edit');
    }

    /**
     * @desc form add user to role handle
     */
    public function formAddPossiblePrivilegeSubmitted(SubmitButton $button) {
        $data = $button->getForm()->getValues();

        $this->model->addPossiblePrivilege($data);
        $this->id = $data['section_id'];
    }

    /**
     * @desc returns true if link is valid (presenter/view/item)
     *  used for link form test
     */
    public function linkValid($control) {
        $arr = explode('/', $control->value);
        if (count($arr) > 3 | $arr[0] == "") {
            return false;
        } else {
            return true;
        }
    }

    protected function createComponent($name) {
        switch ($name) {
            case "mapItemsTable":
                $table = new TreeTable($this, $name);

                $table->setData($this->modelMItems->getTree())
                        ->addColumn('name', 'název')
                        ->addColumn('section', 'sekce');

                $table->addActionPrototype(new WebAction('moveUp!', $this->modelMItems, $this))
                        ->addActionArgPrototype(array('itemId' => 'id'))
                        ->setIconName('up');

                $table->addActionPrototype(new WebAction('moveDown!', $this->modelMItems, $this))
                        ->addActionArgPrototype(array('itemId' => 'id'))
                        ->setIconName('down');

                $table->addActionPrototype(new WebAction('editItem', $this->modelMItems, $this))
                        ->addActionArgPrototype(array('itemId' => 'id'))
                        ->setIconName('edit');

                $table->addActionPrototype(new WebAction('deleteItem!', $this->modelMItems, $this))
                        ->addActionArgPrototype(array('itemId' => 'id'))
                        ->setIconName('delete')
                        ->setConfirmMessage('opravdu chcete smazat tuto položku?');


                $table->addActionPrototype(new WebAction('newItem', $this->modelMItems, $this))
                        ->addActionArgPrototype(array('parentId' => 'id'))
                        ->setIconName('add');
                return;
            case "mapsList":
                $t = new DsTable($this, $name);

                $t->setDataSource($this->model->dataSource());

                $t->addColumn('id', 'id', true);
                $t->addColumn('name', 'název', true);
                $t->addColumn('identificator', 'indikátor', true);

                $t->addActionPrototype(new WebAction('edit', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('edit');

                $t->addActionPrototype(new WebAction('delete!', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('delete')
                        ->setConfirmMessage('opravdu chcete mapu smazat?');

                return;
            case "defaultActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addElement($this->link('new'), 'add', 'vytvořit novou mapu');
                return;
            case "editActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addElement($this->link('newItem'), 'add', 'přidat položku');
                return;
            case "formNewItem":
            case "formEditItem":
                $form = new MyForm($this, $name);

                $form->addHidden('map_id')->setDefaultValue($this->id);

                $form->addGroup('název a popis');
                $form->addText('name', 'název položky:')
                        ->addRule(NForm::FILLED, 'Prosím zadejte alespoň název položky.');

                $form->addTextArea('description', 'popis:', 30, 3);

                $form->addGroup('rodičovská položka');

                $form->addSelect('parent_id', 'rodič:', $this->modelMItems->getTree()->getFormArray($this->itemId));

                $form->addGroup('sekce');

                $form->addSelect('section_id', 'sekce:',
                                $this->modelSections->getTree()->getFormArray())
                        ->addRule(~NForm::EQUAL, 'Vyberte sekci.', array(''));

                $form->setCurrentGroup();

                $form->addSubmit('ok', 'uložit')
                        ->onClick[] = array($this, 'formItemSubmitted');

                $form->addSubmit('cancel', 'zrušit')
                                ->setValidationScope('')
                        ->onClick[] = array($this, 'formItemCanceled');

                if ($name === "formEditItem")
                    $form->addHidden('id');
                $form->setHandle($this->modelMItems, $name === "formEditItem" ? 'update' : 'insert');

                return;
            case "formNew":
            case "formEdit":
                $form = new MyForm($this, $name);

                $form->addGroup('název a popis');
                $form->addText('name', 'název:')
                        ->addRule(NForm::FILLED, 'Prosím zadejte alespoň název.');

                $form->addText('identificator', 'identifikátor');

                $form->addTextArea('description', 'popis:', 30, 3);

                $form->setCurrentGroup();

                $form->addSubmit('ok', 'uložit')
                        ->onClick[] = array($this, 'formSubmitted');

                $form->addSubmit('cancel', 'zrušit')
                                ->setValidationScope('')
                        ->onClick[] = array($this, 'formCanceled');

                if ($name === "formEdit")
                    $form->addHidden('id');
                $form->setHandle($this->model, $name === "formEdit" ? 'update' : 'insert');

                return;
            default:
                parent::createComponent($name);
        }
    }

}

