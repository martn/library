<?php

require_once dirname(__FILE__) . '/Base/TreeBasePresenter.php';

class Front_SectionsPresenter extends Front_TreeBasePresenter {

    //const

    public function startup() {
        parent::startup();

        $this->model = $this->modelSections;
    }

    /**
     * @desc edit stage
     */
    public function renderEdit($id) {
//        settype($id, "integer");

        $section = $this->model->find($id);

        $this->id = $id;
        $this->template->id = $id;

        $form = $this->getComponent('formEdit');

        $section['link'] = $this->model->niceLink($section);
        unset($section['item']);

        $form->setDefaults($section);

        $this->template->form = $form;

// ======== POSSIBLE PERMISSIONS ===============

        /*
          $this->template->privileges_list_header = "Seznam možností";

          $form = $this->getComponent('formAddPossiblePrivilege');
          $form->setDefaults(array('section_id'=>$this->id));

          $this->template->formAddPossiblePrivilege = $form; */
    }

    /**
     * @desc edit stage
     */
    public function renderNew($id) {
        $this->addTitle('Nová sekce');
        $form = $this->getComponent('formNew')->setDefaults(array('parent_id' => $id));
    }

    /**
     * @desc default render
     */
    public function renderDefault() {

        $this->addTitle("Sekce");
    }



    /**
     * @desc removes whole group of privileges
     */
    public function handleDelete($id) {
        $this->signalHandle("Sekce byla smazána.");
    }


    /**
     * @desc new form handle
     */
    public function formSubmitted(NSubmitButton $button) {
        $this->standardFormSubmitted($button, "Sekce byla uložena.");
    }


    
    /**
     * @desc form add user to role handle
     */
    public function formAddPossiblePrivilegeSubmitted(SubmitButton $button) {
        $data = $button->getForm()->getValues();

        $this->model->addPossiblePrivilege($data);
        $this->id = $data['section_id'];

        //echo "skjdflsd";
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

    /**
     * @desc factory for createComponent
     */
    protected function getFromFactory($name) {
        switch ($name) {
            case 'form':

                return $form;
            default:
                return parent::getFromFactory($name);
        }
    }

    protected function createComponent($name) {
        switch ($name) {
            case "sectionsTable":
                $table = new TreeTable($this, $name);

                $table->setData($this->model->getTree())
                        ->addColumn('name', 'název')
                        ->addColumn('link', 'odkaz');

                $table->addActionPrototype(new WebAction('delete!', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('delete')
                        ->setConfirmMessage('opravdu chcete smazat tuto sekci?');

                $table->addActionPrototype(new WebAction('edit', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('edit');

                $table->addActionPrototype(new WebAction('new', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('add');
                return;
            case "defaultActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addElement($this->link('new'), 'add', 'vytvořit novou sekci');
                return;

            case "formAddPossiblePrivilege":
                $form = new MyForm($this, $name);

                $form->addHidden('section_id');

                $form->addGroup('možnosti');
                $form->addSelect('privilege_id', 'přidat možnost:', $this->modelPrivileges->getArray());

                $form->addSubmit('ok', 'přidat')
                        ->onClick[] = array($this, 'formAddPossiblePrivilegeSubmitted');
                return;

            case "formNew":
            case "formEdit":
                $form = new MyForm($this, $name);

                $form->addGroup('název a popis');
                $form->addText('name', 'název sekce:')
                        ->addRule(NForm::FILLED, 'Prosím zadejte alespoň název sekce.');

                $form->addText('description', 'popis:');

                $form->addGroup('presenter | view | argumenty');
                $form->addText('link', 'link (presenter/view/item)', 40, 255)
                        ->addRule(NForm::FILLED, 'Zadejte link (presenter/view/item)')
                        ->addRule(array($this, 'linkValid'), 'Zadaný link má neplatný formát \'presenter/view/item\'');

                $form->addGroup('rodičovská sekce');
                $form->addSelect('parent_id', 'zvolte rodičovskou sekci:',
                        $this->model->getTree()->getFormArray());

                $form->addGroup('práva přístupu');
                $form->addRadioList('restriction', 'omezení',
                        array(Sections::RESTRICTION_RULE => 'svázat s pravidlem',
                            Sections::RESTRICTION_PARENT => 'dle rodič.',
                            Sections::RESTRICTION_NONE => 'žádné'))->getLabelPrototype()->setAttribute('class', 'sectionsPrivilegesRadio');

                // TODO: vyresit vzhled formulare

                $form->addSelect('lib_acl_join_id', 'pravidlo',
                        $this->modelPrivileges->getSelectBoxArray());

                $form->setCurrentGroup();

                $form->addSubmit('ok', 'uložit')
                        ->onClick[] = array($this, 'formSubmitted');

                $form->addSubmit('cancel', 'zrušit')
                                ->setValidationScope('')
                        ->onClick[] = array($this, 'formCanceled');

                if($name !== "formNew") $form->addHidden('id');

                $form->setHandle($this->model, $name === "formNew" ? 'insert' : 'update');
                return;
            default:
                parent::createComponent($name);
        }
    }

}

