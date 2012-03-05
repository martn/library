<?php

require_once dirname(__FILE__) . '/Base/TreeBasePresenter.php';

class Front_GroupsPresenter extends Front_TreeBasePresenter {

    public $advanced;

    public function startup() {
        parent::startup();

        $this->model = $this->modelRoles;


        try {
            $this->advanced = $this->loadVariable('advanced', $this->getAction());
        } catch (NotFoundException $e) {

            $this->setStateAdvanced(false);
        }
    }

    public static function getPersistentParams() {
        return array_merge(parent::getPersistentParams(),
                array('id', 'advanced'));
    }

    // =============== HANDLES ======================================

    /**
     *
     * @param $id 
     */
    function handleRemoveUser($id, $userId) {
///        $this->flashMessage($this->id." a ".$id);
        $this->signalHandle("Uživatel byl vyřazen z této skupiny.");
    }

    public function handleSelectTab($name) {
        $this->getComponent('privilegesTabControl')->select($name);
    }

    private function setStateAdvanced($advanced) {
        $this->saveVariable('advanced', $advanced, $this->getAction());
        $this->advanced = $advanced;
    }

    public function handleAdvancedState($advanced) {
        $this->setStateAdvanced($advanced);
    }

    function renderEdit($id) {
        $this->addTitle('Úprava uživatelské skupiny');
        $this->getComponent('formEdit')->setDefaults($this->model->find($id));
    }

    function renderNew($id) {
        $this->addTitle('Nová uživatelská skupina');
        $this->getComponent('formNew')->setDefaults(array('parent_id' => $id));
    }

    /**
     * @desc edit stage
     */
    public function renderDetail($id) {
        //$this->id = $id;
        $this->addTitle("Detail uživatelské skupiny");
        $this->template->data = $this->model->find($id);

//        $this->template->id = $id;
    }

    public function renderDefault() {
        $this->addTitle("Uživatelské skupiny");
    }

    /**
     * @desc action section access - item test
     */
    public function actionPrivileges($id) {
        $this->actionCheck(new WebAction('editPrivileges', $this->model, $this, array('id' => $id)));
    }

    /**
     * @desc renders section privileges edit stage
     */
    public function renderPrivileges($id) {

        $this->template->role = $this->modelRoles->find($id);

        $this->template->form = $this->getComponent('formPrivileges');

        $this->template->advanced = $this->advanced;

        /*
          if($this->user->isInRole('superadmin'))
          {
          $menu = new QuickMenu();
          if($this->advanced)
          {
          $menu->addElement($this->link("advancedState!", false), "základní","");
          } else {
          $menu->addElement($this->link("advancedState!", true), "pokročilé","");
          }
          $this->template->advanced_menu = $menu;
          } */
    }

    /**
     * @desc new form handle
     */
    public function formSubmitted(NSubmitButton $button) {
        $this->standardFormSubmitted($button, "Uživatelská skupina byla uložena.");
    }

    
    /**
     * @desc privileges form handle
     */
    public function formPrivilegesSubmitted(NSubmitButton $button) {
        $this->standardFormSubmitted($button, "Práva byla nastavena.");
    }


    /**
     * @desc privileges form handle
     */
    public function formNewGroupSubmitted(NSubmitButton $button) {
        $data = $button->getForm()->getValues();

        $data['name'] = $data['groupName'];
        unset($data['groupName']);

        $this->modelPrivileges->addGroup($data);

        //print_r($data);

        $this->flashMessage('Skupina byla založena.', 'ok');
        $this->redirect($this->getAction());
    }

    
    /**
     * @desc
     */
    public function privilegesGroupUpdate(NSubmitButton $button) {
        $data = $button->getForm()->getValues();


        foreach ($data as $key => $id) {
            if (substr($key, 0, 8) == "itemName") {
                $id = substr($key, 8);

                if ($data['itemDelete' . $id]) {
                    $this->modelPrivileges->deleteRule($id);
                } else {

                    $args = array('id' => $id,
                        'name' => $id,
                        'resource_id' => $data['itemResource' . $id],
                        'privilege_id' => $data['itemPrivilege' . $id]);

                    $this->modelPrivileges->updateRule($args);
                }
            }
        }


        if ($data['name'] != '')
            $this->modelPrivileges->addRule(array('group_id' => $data['groupId'],
                'resource_id' => $data['resource_id'],
                'privilege_id' => $data['privilege_id'],
                'name' => $data['name']));

        $this->modelPrivileges->updateGroup(array('id' => $data['groupId'],
            'name' => $data['groupName']));


        $this->flashMessage('Práva upraveny');
        $this->invalidateControl('flashes');

        $tabName = 'tab' . $data['groupId'];


        //$this->removeComponent($button->getForm());
        //$button->getForm()->destroy();
        //$this->handleAdvanced(substr($button->getForm()->getName(),3));
        //$this->invalidateControl($tabName);
        //$this->handleBasic($tabName);
        //       $this->getComponent('privilegesTabControl')->redraw(TabControl::REDRAW_CURRENT);

        $this->redirect('selectTab!', $tabName);
        // invalidateControl(substr($button->getForm()->getName(),3));
    }

    /**
     * @desc returns true if type abbreviation is unique
     */
    public function privilegesGroupUnique(NFormControl $control) {
        $data = $control->getForm()->getValues();

        if (isset($data['oldGroupName'])) {
            if ($data['oldGroupName'] == $data['groupName'])
                return true;
        }

        foreach ($this->modelPrivileges->getGroups() as $group) {
            if ($group->name == $data['groupName'])
                return false;
        }
        return true;
    }

    /* ### Tab Template ### */

    /*
      function createTabNew($name, Tab $tab){
      $template = $this->createTemplate(); // Zde bych mohl volat i new Template; (nepotřebuji v template mít $control, $presenter a podobně)
      $template->setFile(Environment::expand("%appDir%/FrontModule/templates/Groups/Tabs/newForm.phtml"));

      $form = new MyForm($tab, $name);

      $form->addGroup();
      $form->addText("groupName", "jméno skupiny")
      ->addRule(Form::FILLED, "Něco je povinné!");
      //->addRule(array($this, "privilegesGroupUnique"),"skupina už existuje");

      $form->setCurrentGroup(null);
      $form->addSubmit("ok", "přidat")
      ->onClick[] = array($this, "formNewGroupSubmitted");

      $template->form = $form;

      return $template;
      } */

    /**
     * renders group name as anchor to the list of users
     * @param string $content
     * @param Traversable $data
     * @return string
     */
    function renderGroupAnchor($standardContent, $rowData) {
        return NHtml::el('a')->href($this->link('detail', $rowData->id))->setText($standardContent);
    }




    function renderTabPrivileges(Tab $tab) {

        $list = new ListManualTable();

        //$list->addHead("prdel");
        //print_r($tab->content);

        foreach ($tab->content->getControls() as $control) {
            //print_r($control);
            $list->addRow();

            //echo $control->getLabel();
            $list->addData($control->getLabel());
            //$list->addData($control->getReflection()->getName());
            $control->getContainerPrototype()->setName("div")->class("radio-horizontal");
            $control->getSeparatorPrototype()->setName("");

            $list->addData($control->getControl());
        }

        $list->render();
    }


    
    protected function createComponentUsersTable() {
        $t = new DsTable($this, 'usersTable');

        //    print_r("item: ".$this->id);

        $t->setDataSource($this->modelUsers->getUsersInRole($this->id));

        $t->addColumn('name', 'jméno', true);
        $t->addColumn('surname', 'příjmení', true);
        $t->addColumn('username', 'uživatelské jméno', true);

        $t->addActionPrototype(new WebAction('Users:detail', $this->modelUsers, $this))
                ->addActionArgPrototype(array('id' => 'id'))
                ->setIconName('detail');

        $t->addActionPrototype(new WebAction('Users:edit', $this->modelUsers, $this))
                ->addActionArgPrototype(array('id' => 'id'))
                ->setIconName('edit');

        $t->addActionPrototype(new WebAction('removeUser!', $this->modelRoles, $this))
                ->addActionArgStatic(array('id' => $this->id))
                ->addActionArgPrototype(array('userId' => 'id'))
                ->setIconName('delete')
                ->setConfirmMessage('opravdu chcete uživatele vyjmout z této skupiny?');

        return $t;
    }

    protected function createComponent($name) {
     /*   if (substr($name, 0, 3) == 'prv') {

            $form = new MyForm($this, $name);
            //$form->getElementPrototype()->class('ajax');

            $form->addGroup('skupina');

            $form->addHidden("oldGroupName");
            $form->addHidden("groupId");

            $form->addText('groupName', 'název skupiny')
                    ->addRule(NForm::FILLED, "Vyplňte pole 'název skupiny'");
            //->addRule(array($this, "privilegesGroupUnique"),"skupina už existuje.");


            $res_array = $this->modelPrivileges->getResourcesArray();
            $prv_array = $this->modelPrivileges->getArray();


            $form->addGroup('položky');

            //          /echo substr($name, 6);
            foreach ($this->modelPrivileges->getRules(substr($name, 6)) as $join) {

                $chkbox = $form->addCheckbox('itemDelete' . $join['id'], 'smazat');

                $t = $form->addText('itemName' . $join['id'], '');
                $t->addConditionOn($chkbox, NForm::EQUAL, false)
                        ->addRule(NForm::FILLED, 'Vyplňte název práva.');


                $s = $form->addSelect('itemResource' . $join['id'], '', $res_array);
                //$s->setDefaultValue($join['resource_id']);

                $s = $form->addSelect('itemPrivilege' . $join['id'], '', $prv_array);
                //$s->setDefaultValue($join['privilege_id']);
            }

            $form->addGroup('nová položka');

            $form->addText('name', 'název');

            $form->addSelect('resource_id', 'zdroj', $res_array);
            $form->addSelect('privilege_id', 'akce', $prv_array);

            $form->setCurrentGroup();

            $form->addSubmit('ok', 'uložit')
                    ->onClick[] = array($this, 'privilegesGroupUpdate');
            return;
        }*/

        switch ($name) {
            case "defaultActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addElement($this->link('new'), 'add', 'vytvořit novou skupinu');
                return;
            case "editActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addElement($this->link('privileges'), 'application', 'přístupová práva');
                return;
            case "privilegesTabControl":
                $tc = new TabControl($this, $name);
                $tc->mode = TabControl::MODE_PRELOAD;
                //$tc->sortable = true;
                //$tc->jQueryTabsOptions = "{ fx: { height: 'toggle',opacity:'toggle',marginTop:'toggle',marginBottom:'toggle',paddingTop:'toggle',paddingBottom:'toggle'} }";

                $form = $this->getComponent('formPrivileges');

                foreach ($this->modelPrivileges->getGroups() as $group) {
                    $t = $tc->addTab("tab" . $group->id);
                    $t->header = $group->name;

                    $t->content = $form->getGroup($group->id);
                    //$t->contentFactory = array($this,"createTabPrivileges");
                    $t->contentRenderer = array($this, "renderTabPrivileges");
                }

                /*
                  if($this->user->isInRole('superadmin')) {
                  $t = $tc->addTab("new");
                  $t->header = "+";
                  $t->contentFactory = array($this,"createTabNew");
                  } */

                return;
            case "formPrivileges":
                //$form = $this->modelRoles->getPrivilegesForm($this->id);

                $form = new MyForm($this, $name);

                foreach ($this->modelPrivileges->getGroups() as $group) {
                    $form->addGroup($group->id);

                    foreach ($this->modelPrivileges->getRules($group->id) as $join) {

                        if ($this->modelRoles->parentRoleIsAllowed($this->id, $join->id)) {
                            $rl = $form->addRadioList('fake' . $join->id, $join->name, array('Ano'))
                                            ->setDefaultValue(0);

                            $rl->setDisabled(true);
                        } else {

                            $form->addRadioList('allowed' . $join->id, $join->name, array('Ne', 'Ano'))
                                    ->setDefaultValue($this->modelAcl->roleIsAllowed($this->id, $join->id));
                        }
                    }
                }

                $form->setCurrentGroup(null);
                $form->addHidden('id')->setDefaultValue($this->id);

                $form->setHandle($this->modelRoles, 'privilegesUpdate');

                $form->addSubmit('ok', 'uložit změny')
                        ->onClick[] = array($this, 'formPrivilegesSubmitted');

                $form->addSubmit('cancel', 'zrušit')
                                ->setValidationScope('')
                        ->onClick[] = array($this, 'formCanceled');

                return;
            case "groupsTable":
                $table = new TreeTable($this, $name);

                $table->setData($this->model->getTree())
                        ->addColumn('name', 'název')
                        ->setRenderer(array($this, 'renderGroupAnchor'))
                        ->addColumn('description', 'popis');

                $table->addActionPrototype(new WebAction('delete!', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('delete')
                        ->setConfirmMessage('opravdu chcete smazat tuto skupinu?');

                $table->addActionPrototype(new WebAction('edit', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('edit');

                $table->addActionPrototype(new WebAction('privileges', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('application');

                $table->addActionPrototype(new WebAction('new', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('add');
                return;

            case "formNew":
            case "formEdit":

                $form = new MyForm($this, $name);

                $form->addGroup('název a popis');
                $form->addText('name', 'název skupiny')
                        ->addRule(NForm::FILLED, 'název je povinný');

                $form->addQuickHelp($form->addText('description', 'popis'),
                        'krátký popis');

                $form->addGroup('nadřazená skupina');

                $pId = $form->addSelect('parent_id', 'nadřazená skupina');

                $form->addQuickHelp($pId, 'nadřazená skupina v hierarchii skupin');


                $cutId = $name === "formEdit" ? $this->id : NULL;
                $pId->setItems($this->modelRoles->getParentRoleTree()->getFormArray($cutId));

                if ($name === "formEdit") $form->addHidden('id');
                
                $form->setHandle($this->modelRoles, $name === "formEdit" ? 'update' : 'insert');

                $form->setCurrentGroup();
                $form->addSubmit('ok', 'uložit')
                        ->onClick[] = array($this, 'formSubmitted');

                $form->addSubmit('cancel', 'zrušit')
                                ->setValidationScope('')
                        ->onClick[] = array($this, 'formCanceled');

                return;
            default:
                parent::createComponent($name);
        }
    }

}

