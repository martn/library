<?php

require_once dirname(__FILE__) . '/Base/BasePresenter.php';

class Front_TypesPresenter extends Front_BasePresenter {

    protected $fieldType;
    public $fieldId;
    public $groupId;

    //public $sharedId;

    public function startup() {
        parent::startup();

        $this->model = $this->modelTypes = new TypesModel($this->id);
        $this->modelAttributesGroups->setId($this->id);
    }

    public static function getPersistentParams() {
        return array_merge(parent::getPersistentParams(), array('fieldId'));
    }

    // ================== HANDLES ============================

    /**
     * @desc handles delete signal
     */
    public function handleMoveFieldUp($fid) {
        $this->setActionName('moveUp');
        $this->signalHandle();
    }

    /**
     * @desc handles delete signal
     */
    public function handleMoveFieldDown($fid) {
        $this->setActionName('moveDown');
        $this->signalHandle();
    }

    /**
     * @desc handles delete signal
     */
    public function handleMoveGroupUp($groupId) {
        $this->setActionModel($this->modelAttributesGroups);
        $this->setActionName('moveUp');
        $this->signalHandle();
    }

    /**
     * @desc handles delete signal
     */
    public function handleMoveGroupDown($groupId) {
        $this->setActionModel($this->modelAttributesGroups);
        $this->setActionName('moveDown');
        $this->signalHandle();
    }

    public function handleToggleGroupSharing($gid) {
        //$this->sharedId = $sharedId;

        try {
            $res = $this->modelAttributesGroups->toggleGroupSharing($gid);

            if (!is_numeric($res)) {

                $t = '';
                foreach ($res as $type) {
                    $t .= "'" . $type->name . "', ";
                }
                $this->flashMessage('Nelze zrušit sdílení, skupina je součástí typů ' . $t, 'error');
            }

            $this->invalidateControl('mainPanel');
        } catch (NotFoundException $e) {
            
        }
    }

    /**
     * @desc handles delete signal
     */
    public function handleDeleteField($fielId) {
        $this->setActionName('delete');
        $this->signalHandle("Pole bylo smazáno.", "Chyba, akce není možná.");
    }

    /**
     * @desc handles delete group
     * @param unknown_type $fid
     * @return unknown_type
     */
    public function handleRemoveGroup($token) {
        $this->signalHandle("Skupina byla odstraněna.");
    }

    // ================== RENDERERS ===============================

    /**
     * @desc default render
     */
    public function actionDefault() {
        $this->clearPersistentParams('fieldId');
    }

    public function actionDefinition($id) {
        $this->actionCheck(new WebAction('definition', $this->model, $this, array('id' => $id)));
        $this->clearPersistentParams('fieldId');

    }

    public function renderDefinition($id) {

        $typeData = $this->model->find($id);
        $this->template->typeData = $typeData;

        $itemCount = $this->modelItems->dataSource($id, 'type_id')->count();
        if($itemCount > 0) {
            $this->flashMessage("Pozor, v knihovně je $itemCount položek tohoto typu.
                                Úpravy dělejte s rozvahou.");
        }

        /*

          $table->addHead('název pole', 75);
          $table->addHead('skupina', 25);
          //  $table->addHead('sdílené');




          $this->template->table = $table;

          $menu = new QuickMenu('vertical');
          $menu->addElement($this->link('addField'),$this->getElement('add_icon_medium').'přidat nové pole');
          $this->template->add_menu = $menu; */
        //
        /*
          foreach($this->modelAttributesGroups->getGroups($id) as $group)
          {
          $table->addGroup();

          $menu = new QuickMenu();

          //          	$menu->addElement($this->link('removeField!',array('fid'=>$attr->id)),$this->getElement('delete_icon_small'));
          //          	$menu->addConfirm("Chcete smazat pole ".$attr->name."?");

          $menu->addElement($this->link('deleteGroup!', array('gid'=>$group->link_id)),
          $this->getElement('delete_icon_small'),
          '',
          true,
          "Chcete smazat skupinu ".$group->name."? (skupina se nesmaže z typů, kde je sdílená)");

          $menu->addElement($this->link('moveGroupUp!', array('gid'=>$group->link_id)),
          $this->getElement('up_icon_small'),
          '',
          true);

          $menu->addElement($this->link('moveGroupDown!', array('gid'=>$group->link_id)),
          $this->getElement('down_icon_small'),
          '',
          true);

          $menu->addElement($this->link('addField',array('gid'=>$group->id)),
          $this->getElement('add_icon_small'));

          $menu->addElement($this->link('toggleGroupSharing!',array('gid'=>$group->id)),
          $this->getElement($group->shared ? 'unlocked_icon_small' : 'locked_icon_small'),
          '',
          true,
          $group->shared ? "Chcete zrušit sdílení skupiny?" : "Chcete sdílet skupinu?");


          $table->addData($menu);

          $this->fillEditSubTable($table, $this->modelAttributes->getAttributesTree($group->id));
          } */
    }

    public function renderEdit($id) {
        $this->clearPersistentParams('fieldId');

        $this->getComponent('formEdit')->setDefaults($this->model->find($id));

        // ================ EDITOR MENU ===================
        /* if($this->isAllowed(self::RESOURCE_TYPES, self::PRIVILEGE_EDIT)) {
          $menu = new QuickMenu('vertical');
          $menu->addElement($this->link('addField'),$this->getElement('add_icon_medium').'přidat nové pole');

          $menu->addElement($this->link('editSignature'),$this->getElement('application_icon_medium').'úprava signatury');

          $menu->addElement($this->link('definition'),$this->getElement('configure_icon_medium').'definice polí');

          $this->template->editor_menu = $menu;

          } */

        //$this->template->typeData = $this->model->find($id);
    }

    /**
     * @desc action add field test of correct attributes
     */
    public function actionAddField($id, $groupId) {
        $this->actionCheck(new WebAction('addField', $this->model, $this, array('id' => $id, 'groupId' => $groupId)));

        if (empty($this->fieldType)) {
            $arr = array_keys($this->modelAttributes->getFieldTypes());
            $this->fieldType = $arr[0];
        }

        $this->groupId = $groupId;

        $this->setBackLink("definition");
    }

    /**
     * @desc renders add field form
     */
    public function renderAddField($id, $groupId) {
        $this->getComponent('formFieldNew')->setDefaults(array('group_id' => $groupId));
    }

    function actionEditGroup($id, $groupId) {
        $this->actionCheck(new WebAction('editGroup', $this->modelAttributesGroups, $this, array('id' => $groupId)));
        $this->setBackLink('definition');
    }

    function renderEditGroup($id, $groupId) {
        $this->getComponent('formEditGroup')->setDefaults($this->modelAttributesGroups->find($groupId));
    }

    /**
     * @desc renders edit field form
     */
    public function actionEditField($id, $fieldId) {
        $this->actionCheck(new WebAction('editField', $this->model, $this, array('id' => $id, 'fieldId' => $fieldId)));

        $attr = $this->modelAttributes->find($fieldId);
        $this->fieldType = $attr->type;
        $this->groupId = $attr->group_id;

        $this->setBackLink("definition");
    }



    public function actionSignature($id) {
        $this->actionCheck(new WebAction('signature', $this->model, $this, array('id' => $id)));
    }


    
    /**
     * @desc renders signature edit form
     */
    public function renderSignature($id) {
        $typeData = $this->model->find($id);
        $this->getComponent('formSignature')->setDefaults($typeData);
        $this->template->typeData = $typeData;
    }

    /**
     * @desc renders edit field form
     */
    public function renderEditField($id, $fieldId) {

        $fieldData = $this->modelAttributes->find($fieldId);

        $this->getComponent('formFieldEdit')->setDefaults($fieldData);

        $this->template->fieldData = $fieldData;
    }

    /**
     * @desc renders field data filler
     */
    public function actionFieldData($id, $fieldId) {
        $this->actionCheck(new WebAction('fieldData', $this->modelAttributes, $this, array('id' => $fieldId)));

        $this->setBackLink($this->backlink ? $this->backlink : 'definition');
    }

    /**
     * @desc renders field data filler
     */
    public function renderFieldData($id, $fieldId) {
        $this->template->fieldData = $fieldData = $this->modelAttributes->find($fieldId);

        $form = $this->getComponent('formSelectData');
        $this->template->form = $form;

        $form['parent_data_attribute']->setDefaultValue($fieldData['parent_data_attribute']);

        $table = new ListManualTable($this, 'fieldDataTable');

        $table->addHead("zkratka (unikátní)");
        $table->addHead("název");
        $table->addHead("nadřazená hodnota");
        $table->addHead("smazat");


        foreach ($this->modelAttributes->getListData($fieldId, true) as $data) {

            $formKey = $form["fd_key_" . $data['id']];
            $formVal = $form["fd_val_" . $data['id']];
            $formChk = $form["fd_chk_" . $data['id']];
            $formPar = $form["fd_par_" . $data['id']];

            $formKey->setDefaultValue($data['abbr']);
            $formVal->setDefaultValue($data['value']);

            $formPar->refresh();
            $formPar->setDefaultValue($data['parent_id']);

            $table->addRow();

            $table->addData($formKey->getControl());
            $table->addData($formVal->getControl());
            $table->addData($formPar->getControl());
            $table->addData($formChk->getControl());
        }

        $table->addRow();
        $table->addData("nový řádek:");

        $form["parent_id"]->refresh();

        $table->addRow();
        $table->addData($form["abbr"]->getControl());
        $table->addData($form["value"]->getControl());
        $table->addData($form["parent_id"]->getControl());

        $this->template->formBody = $table;
    }

    public function renderNew() {
        
    }

    // ======================= form handlers ========================
    /**
     * @desc go to add field page submitted
     */
    public function formSignatureSubmitted(NSubmitButton $button) {
        $this->standardFormSubmitted($button, "Signatura byla upravena.");
    }

    
    function formAddGroupSubmitted(NSubmitButton $button) {
        $this->standardFormSubmitted($button, 'Přidána skupina polí', $this->getAction());
    }

    /**
     * @desc add field submitted
     */
    public function formFieldSubmitted(NSubmitButton $button) {
        $this->standardFormSubmitted($button, "Pole uloženo.");
    }

    /**
     * @desc add field submitted
     */
    public function formEditFieldSubmitted(NSubmitButton $button) {
        $data = $button->getForm()->getValues();
        $this->modelAttributes->updateAttribute($data, $this->id);
        $this->flashMessage('pole upraveno.');

        $this->clearPersistentParams('fid');

        $this->redirect('definition');
    }

    /**
     * @desc select data submitted
     */
    public function formSelectDataSubmitted(NSubmitButton $button) {
        $this->standardFormSubmitted($button, "Data uložena.", $this->getAction());
    }

    /**
     * @desc select data finish
     */
    public function formSelectDataFinish(NSubmitButton $button) {
        $this->standardFormSubmitted($button);
    }

    /**
     * @desc select data submitted
     */
    public function formFinishSubmitted(SubmitButton $button) {
        $backlink = $this->backlink;
        $this->backlink = '';
        $this->redirect($backlink);
    }


    
    /**
     * @desc returns true if type abbreviation is unique
     */
    public function ruleSignatureValid(NFormControl $control) {
        $data = $control->getForm()->getValues();
        $sig = trim($data['signature']);

        try {

            $this->modelTypes->formSignatureValid($sig, $this->id);
            return true;
        } catch (Exception $e) {

            $this->flashMessage($e->getMessage(), "error");
            return false;
        }
    }



    /**
     * @desc returns true if type abbreviation is unique
     */
    public function ruleTypeAbbrUnique(NFormControl $control) {
        $data = $control->getForm()->getValues();

        try {
            $type = $this->modelTypes->find($data['abbr'], 'abbr', 's');

            if ($type->id == $this->id) {
                return true;
            } else {
                return false;
            }
        } catch (NotFoundException $e) {
            return true;
        }
    }

    /**
     * @desc returns true if list value is unique
     */
    public function ruleListValueUnique(NFormControl $control) {
        $data = $control->getForm()->getValues();

        $keys = array();

        foreach ($data as $key => $val) {

            $k = false;
            $name_array = explode("_", $key);

            if ($key == 'abbr')
                $k = true;

            if (count($name_array) > 2) {
                if ($name_array[0] == "fd" & $name_array[1] == "key")
                    $k = true;
            }

            if ($k) {
                if (in_array($val, $keys)) {
                    return false;
                } else {
                    array_push($keys, $val);
                }
            }
        }

        return true;
    }

    // ===================== FACTORIES =============================


    function createTabSharedGroupsTemplate($name, Tab $tab) {
        $template = $this->createTemplate(); // Zde bych mohl volat i new Template; (nepotřebuji v template mít $control, $presenter a podobně)
        $template->setFile(NEnvironment::expand("%appDir%/FrontModule/templates/Types/Tabs/sharedForm.phtml"));

        $template->form = $this->getComponent('formSharedGroups');
        $template->table = $this->getComponent('sharedGroupsTable');
        return $template;
    }


    function getParentAttrListValues(NAppForm $form, DependentSelectBox $dependentSelectBoxName) {
        return $this->modelAttributes->getListData($form['parent_data_attribute']->getValue());
    }



    protected function  createComponent($name) {
        switch ($name) {
            case "defaultActionsMenu":
                $menu = $this->getComponentPrototype("menuPageActions", $name);

                $menu->addElement($this->link('new'), 'add', 'nový typ');
                return;
            case "editActionsMenu":
                $menu = $this->getComponentPrototype("menuPageActions", $name);

                $menu->addElement($this->link('addField'), 'add', 'přidat pole');
                return;
            case "definitionActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addElement($this->link('addField'), 'add', 'přidat pole');
                $menu->addElement($this->link('default'), 'ok', 'hotovo');
                return;

            case "tableSignatureHelperList":
                $table = new DsTable($this, $name);
                $table->setDataSource($this->model->getSelectBoxAttributes($this->id));

                $table->addColumn('name', 'název pole');
                $table->addColumn('id', 'identifikační číslo');
                return;
            case "tableTypeDefinition":
                $t = new GroupDsTable($this, $name);

                $t->setData($this->modelTypes->getDefinition());

                $t->addColumn('name', 'název');

                $t->addActionPrototype(new WebAction('moveGroupUp!', $this->modelAttributesGroups, $this))
                        ->addActionArgPrototype(array('id' => 'link_id'))
                        ->setIconName('up');

                $t->addActionPrototype(new WebAction('moveGroupDown!', $this->modelAttributesGroups, $this))
                        ->addActionArgPrototype(array('id' => 'link_id'))
                        ->setIconName('down');

                $t->addActionPrototype(new WebAction('removeGroup!', $this->modelAttributesGroups, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->addActionArgStatic(array('type_id' => $this->id))
                        ->setIconName('delete')
                        ->setConfirmMessage('opravdu chcete odstranit tuto skupinu tohoto typu?');

                $t->addActionPrototype(new WebAction('editGroup', $this->modelAttributesGroups, $this))
                        ->addActionArgPrototype(array('groupId' => 'id'))
                        ->setIconName('edit');

                $t->addActionPrototype(new WebAction('addField', $this->model, $this))
                        ->addActionArgPrototype(array('groupId' => 'id'))
                        ->addActionArgStatic(array('id' => $this->id))
                        ->setIconName('add');


                $listRenderer = $t->getListRenderer();

                $listRenderer->addColumn('name', 'název');
                $listRenderer->addColumn('type', 'typ');
                $listRenderer->setRenderer(array($this->modelAttributes, 'getTypeNameFromAbbr'));

                $listRenderer->addActionPrototype(new WebAction('fieldData', $this->modelAttributes, $this))
                        ->addActionArgPrototype(array('fieldId' => 'id'))
                        ->setIconName('configure');

                $listRenderer->addActionPrototype(new WebAction('moveFieldUp!', $this->modelAttributes, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('up');

                $listRenderer->addActionPrototype(new WebAction('moveFieldDown!', $this->modelAttributes, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('down');

                $listRenderer->addActionPrototype(new WebAction('editField', $this->model, $this))
                        ->addActionArgPrototype(array('fieldId' => 'id'))
                        ->addActionArgStatic(array('id' => $this->id))
                        ->setIconName('edit');

                $listRenderer->addActionPrototype(new WebAction('deleteField!', $this->modelAttributes, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('delete')
                        ->setConfirmMessage('opravdu chcete smazat toto pole?');

                return;
            case "tableTypes":
                $t = new DsTable($this, $name);

                $t->addColumn('name', 'název');
                $t->addColumn('description', 'popis');

                $t->setDataSource($this->modelTypes->dataSource());

                $t->addActionPrototype(new WebAction('definition', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('configure')
                        ->setIconTitle('upravit definici');

                $t->addActionPrototype(new WebAction('signature', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('application')
                        ->setIconTitle('signatura');


                $t->addActionPrototype(new WebAction('edit', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('edit');

                $t->addActionPrototype(new WebAction('delete!', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('delete')
                        ->setConfirmMessage('opravdu chcete smazat tento typ?');

                $t->addActionPrototype(new WebAction('moveUp!', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('up');

                $t->addActionPrototype(new WebAction('moveDown!', $this->model, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('down');
                return;
            case "formNewGroup":
            case "formEditGroup":
                $form = new MyForm($this, $name);

                $form->addGroup();
                $form->addText('name', 'název')
                        ->setRequired("název nesmí být prázdný");
                //$form->addCheckbox('shared', 'sdílená skupina');

                $form->setCurrentGroup();

                if ($name === "formEditGroup") {
                    $form->addSubmit('ok', 'uložit')
                            ->onClick[] = array($this, 'formSubmitted');
                    $form->addHidden('id');
                } else {
                    $form->addSubmit('ok', 'OK')
                            ->onClick[] = array($this, 'formAddGroupSubmitted');
                }

                $form->addHidden('type_id', $this->id);
                $form->setHandle($this->modelAttributesGroups, $name === "formNewGroup" ? 'insert' : 'update');

                return;
            case "formSharedGroups":
                $form = new MyForm($this, $name);

                foreach ($this->modelAttributesGroups->getSharedGroups($this->id) as $group) {
                    $form->addCheckbox('group' . $group->id, $group->name);
                }

                $form->addSubmit('ok', 'OK')
                        ->onClick[] = array($this, 'formAddGroupSubmitted');

                $form->addHidden('id', $this->id);
                $form->setHandle($this->model, 'addSharedGroups');

                return;
            case "sharedGroupsTable":
                $table = new ListManualTable($this, $name);

                $form = $this->getComponent('formSharedGroups');

                foreach ($this->modelAttributesGroups->getSharedGroups($this->id) as $group) {

                    $table->addRow();
                    $table->addData($form['group' . $group->id]->getControl());
                    $table->addData($group->name);
                }

                return;
            case "addGroupTabControl":
                $tc = new TabControl($this, $name);
                $tc->mode = TabControl::MODE_PRELOAD;
                //$tc->handlerComponent = $this; // Is automatic

                $t = $tc->addTab("tabSharedGroup");
                $t->header = "Vybrat ze sdílených skupin";
                $t->contentFactory = array($this, "createTabSharedGroupsTemplate");

                $t = $tc->addTab("tabNewGroup");
                $t->header = "Zbrusu nová skupina";
                $t->content = $this->getComponent('formNewGroup');

                return;
            case "formSignature":
                $form = new MyForm($this, $name);

                $form->addGroup();

                $form->addText('signature', 'definice', self::INPUT_WIDTH / 2)
                        ->addRule(array($this, 'ruleSignatureValid'), 'Chyba v definici.');

                $form->setCurrentGroup();

                $form->addSubmit('ok', 'uložit')
                        ->onClick[] = array($this, 'formSignatureSubmitted');

                $form->addHidden('id');
                $form->setHandle($this->model, 'updateSignature');

                return;
            case "formFinish":
                $form = new MyForm($this, $name);

                $form->addSubmit('ok', 'dokončit')
                        ->onClick[] = array($this, 'formFinishSubmitted');
                return;
            case 'formFieldNew':
            case 'formFieldEdit':
                $form = new MyForm($this, $name);

                $form->addGroup();
                $typeSelect = $form->addSelect('type', 'typ položky', $this->modelAttributes->getFieldTypes());

                if ($name === "formFieldEdit")
                    $typeSelect->setDisabled();

                $form->addGroup();
                $form->addSelect('group_id', 'existující skupina',
                        $this->modelAttributesGroups->getGroupsSelectData($this->id));

                $form->addText('group_name', 'název nové skupiny', self::INPUT_WIDTH)
                        ->addConditionOn($form['group_id'], NForm::EQUAL, 0)
                        ->addRule(NForm::FILLED, "vyplňte název nové skupiny");

                $form->addGroup();
                $form->addText('name', 'název pole:', self::INPUT_WIDTH)
                        ->addRule(NForm::FILLED, 'Zadejte název pole.');

                //$form->addText('note', 'krátký popis: (zobrazí se vedle pole)', self::INPUT_WIDTH);

                $form->addTextArea('description',
                        'krátký popis: (zobrazí se jako nápověda)', 40, 3);

                $form->addCheckbox('required', 'povinné pole');

                $form->setCurrentGroup();

                $form->addSubmit('cancel', 'Storno')
                                ->setValidationScope(false)
                        ->onClick[] = array($this, 'formCanceled');

                $form->addSubmit('ok', 'uložit')
                        ->onClick[] = array($this, 'formFieldSubmitted');


                $form->addHidden('type_id')->setDefaultValue($this->id);

                if ($name === "formFieldEdit")
                    $form->addHidden('id');

                $form->setHandle($this->modelAttributes, $name === "formFieldNew" ? 'insert' : 'update');

                return $form;
            case "formSelectData":
                $form = new MyForm($this, $name);

                $form->addGroup();
                $form->addSelect('parent_data_attribute', 'nadřazené pole hodnot', $this->modelAttributes->getRelevantDependableAttributesList($this->fieldId));


                $form->addGroup();
                $abbr = $form->addText('abbr', 'hodnota (unikátní zkratka)', self::INPUT_WIDTH / 2);

                $abbr->addRule(array($this, 'ruleWithoutSpaces'), 'Zkratka nesmí obsahovat mezery.');
                $abbr->addRule(array($this, 'ruleListValueUnique'), 'Zkratka již existuje, zvolte prosím jinou.');

                $val = $form->addText('value', 'název', self::INPUT_WIDTH);

                $val->addConditionOn($abbr, NForm::FILLED)
                        ->addRule(NForm::FILLED, 'vyplňte pole název');

                $abbr->addConditionOn($val, NForm::FILLED)
                        ->addRule(NForm::FILLED, 'vyplňte pole zkratka');

                $form->addDependentSelectBox('parent_id', 'nadřazená hodnota', $form['parent_data_attribute'], array($this, 'getParentAttrListValues'));
                //->setDisabledValue(array('key' => 'value'));
//                         ->setItems();
                if ($this->isAjax())
                    $form["parent_id"]->addOnSubmitCallback(array($this, "invalidateControl"), "formSnippet");


                foreach ($this->modelAttributes->getListData($this->fieldId, true) as $data) {
                    $abbr = $form->addText('fd_key_' . $data->id, '', self::INPUT_WIDTH / 2);
                    $val = $form->addText('fd_val_' . $data->id, '', self::INPUT_WIDTH);

                    $form->addDependentSelectBox('fd_par_' . $data->id, '', $form['parent_data_attribute'], array($this, 'getParentAttrListValues'))
                            ->setLeaveFirstEmpty(true);
                    if ($this->isAjax())
                        $form["fd_par_" . $data->id]->addOnSubmitCallback(array($this, "invalidateControl"), "formSnippet");


                    $abbr->addRule(array($this, 'ruleWithoutSpaces'), 'Zkratka nesmí obsahovat mezery.');
                    $abbr->addRule(array($this, 'ruleListValueUnique'), 'Zkratka již existuje, zvolte prosím jinou.');

                    $val->addConditionOn($abbr, NForm::FILLED)
                            ->addRule(NForm::FILLED, 'vyplňte pole název');

                    $abbr->addConditionOn($val, NForm::FILLED)
                            ->addRule(NForm::FILLED, 'vyplňte pole zkratka');

                    $form->addCheckbox('fd_chk_' . $data->id, '');
                }

                $form->addSubmit('ok', 'uložit')
                        ->onClick[] = array($this, 'formSelectDataSubmitted');

                $form->addSubmit('cancel', 'Storno')
                                ->setValidationScope(false)
                        ->onClick[] = array($this, 'formCanceled');

                $form->addSubmit('finish', 'uložit a ukončit')
                        ->onClick[] = array($this, 'formSelectDataFinish');

                $form->addHidden('attr_id')->setDefaultValue($this->fieldId);
                $form->setHandle($this->modelAttributes, 'updateAttributeData');
                return;
            case "formNew":
            case "formEdit":

                $form = new MyForm($this, $name);

                $form->addGroup();

                $form->addText("name", 'název')->addRule(NForm::FILLED, 'název je povinný');

                $form->addQuickHelp($form->addText("abbr", 'zkratka')
                                ->addRule(NForm::FILLED, 'zkratka je povinná'),
                        'zkratka bude použita např. v signatuře.');

                $form->addTextArea('description', 'popis', 40, 4);

                $form->setCurrentGroup(null);

                $form->addSubmit('ok', 'Uložit')
                        ->onClick[] = array($this, 'formSubmitted');


                $form->addSubmit('cancel', 'Storno')
                                ->setValidationScope(false)
                        ->onClick[] = array($this, 'formCanceled');

                if ($name === "formEdit")
                    $form->addHidden('id');

                $form->setHandle($this->model, $name === "formNew" ? 'insert' : 'update');

                return;
            default:
                parent::createComponent($name);
                return;
        }
    }

}
