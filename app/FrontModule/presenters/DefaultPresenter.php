<?php

require_once dirname(__FILE__) . '/Base/ItemsBasePresenter.php';

class Front_DefaultPresenter extends Front_ItemsBasePresenter {

    //  public $type;

    public function startup() {
        parent::startup();

        /*
          $keys = array_keys($this->modelTypes->getTypesArray());

          if (count($keys) == 0) {
          $this->type = null;
          } else {
          $this->type = $keys[0];
          } */
    }

    // ================== HANDLERS ===================



    public function handleDeleteFile($id) {
        $this->signalHandle("Soubor smazán.", "Akce selhala.", 'filesTable');
    }

    /**
     * @desc action for detail
     * @param unknown_type $item
     * @return unknown_type
     */
    public function actionDetail($id) {
        $this->actionCheck(new WebAction('detail', $this->model, $this, array('id' => $id)));
        // $this->item = $this->modelItems->getIdFromItemUrl($item);
    }

    
    function actionDefault() {
        //throw new Exception('ahoj');
        if ($this->user->isLoggedIn()) {
            $this->redirect('items');
        }
    }

    
    protected function setFilterRule() {
        $session = $this->getSession('searchFilter');

        if (isset($session['user_id'])) {

            // load session data
            
            $rules = $this->loadFilterRules();
            
        } else {

            // load default values
                
            $rules = array('fts'=>'');

            $rules['user_id'] = $this->user->isLoggedIn() ? $this->user->getIdentity()->data['id'] : 0;

            foreach ($this->modelTypes->dataSource() as $type) {
                $rules['type' . $type->id] = true;
            }
        }

        $this->rules = $rules;
        $this->dataSource = $this->modelItems->getFilteredItems($rules);
    }
    
    

    public function actionItems() {
        $this->actionCheck(new WebAction('search', $this->model, $this), true, 'login');

     //   $this->clearVariable('fts', 'searchFilter');
    }

    /*
      public function filesTable($item, $simple=false) {
      $fileTable = new ListTable();
      foreach ($this->modelFiles->dataSource($item, 'item_id', 'i') as $file) {
      $fileTable->addRow();

      $fileTable->addData($file->name);
      //if(!$simple) $fileTable->addData($file->size);

      if ($this->isAllowedToHandle($this->data)) {
      $m = new QuickMenu();

      $m->addElement($this->link('file:download', $file->id), 'stáhnout');

      $m->addElement($this->link('removeFile!', $file->id),
      $this->getElement('delete_icon_small'));
      $m->addConfirm('Opravdu chcete smazat soubor "' . $file->name . '"');

      $fileTable->addData($m);
      }
      }
      return $fileTable;
      } */

    public function renderDefault() {

        $this->template->count = $this->model->dataSource()->count();
        $this->addTitle("Knihovna");
    }

    public function renderItems() {
        $this->addTitle('Hledat');

        $this->setFilterRule();

        $this->getComponent('formFilter')->setDefaults($this->rules);
        $this->getComponent('resultTable')->setDataSource($this->dataSource);
        
        $this->template->fulltext = isset($this->rules['fts']) ? $this->rules['fts'] : ''; 
    }

    /**
     * @desc action for detail
     * @param integer $item
     * @return unknown_type
     */
    public function renderDetail($id) {
        //$this->addTitle($this->data['name']);
        $this->template->item = $this->model->find($id);
    }
    
    
    
 
    /*
      public function renderList() {
      $this->template->table =
      $this->getResultTable($this->model->dataSource());
      }

      public function renderMy() {
      $this->template->table = $this->getResultTable(
      $this->model->getDataSource($this->getUserId(), 'user_id'));
      } */

    public function actionNew($id) {
        
        if (empty($id)) {
        
            $this->redirect('chooseType');
        
        } else {
            
            $this->actionCheck(new WebAction('new', $this->model, $this, array('id' => $id)));
        }

        $this->getComponent('formNew')->setDefaults(array('type_id' => $id));
    }

    
    
    
    function actionChooseType($id) {
        $this->actionCheck(new WebAction('new', $this->model, $this));
        
        
        $this->clearPersistentParams('id');
    }

    
    
    
    public function renderChooseType() {
        $this->addTitle("Vyberte typ položky");
    }

    /**
     * @desc
     */
    public function renderNew($id) {
        $this->template->typeData = $this->modelTypes->find($id);
    }

    /**
     * @desc action for detail
     * @param unknown_type $id
     * @return unknown_type
     */
    public function actionEdit($id) {
        $this->actionCheck(new WebAction('edit', $this->model, $this, array('id' => $id)));

        $item = $this->model->find($id);
        $form = $this->getComponent('formEdit');

        $form->setDefaults($item);

        foreach ($this->modelAttributesGroups->getGroups($item->type_id) as $group) {
            foreach ($this->modelAttributes->findInGroup($group->id) as $attr) {

                $control = $form[$this->model->getFieldNameFromId($attr->id)];
                $data = $this->model->getItemAttrData($id, $attr->id);

                switch ($attr->type) {
                    case AttributesModel::FIELD_SELECT:
                        $control->setDefaultValue($data['integer']);
                        if ($control instanceof DependentSelectBox) {
                            $control->refresh();
                        }
                        break;
                    case AttributesModel::FIELD_CHECKBOX:
                        $control->setDefaultValue($data['boolean']);
                        break;
                    case AttributesModel::FIELD_DATE:
                        $control->setDefaultValue($data['datetime']);
                        break;
                    case AttributesModel::FIELD_TEXT:
                    default:
                        $control->setDefaultValue($data['string']);
                        break;
                }
            }
        }
    }

    public function renderEdit($id) {

        $item = $this->model->find($id);

        $this->template->data = $item;
        $this->template->typeData = $this->modelTypes->find($item->type_id);
    }

    // ============= obsluhy ===================

    /**
     * @desc handle change type
     */
    /*    public function changeType(Form $form) {
      $data = $form->getValues();
      $this->type = $data['type'];
      } */

    /**
     * @desc new form submitted
     */
    public function formSubmitted(NSubmitButton $button) {
        try {
            $this->standardFormSubmitted($button, "Položka přidána do databáze.", $this->getAction());
        } catch (IOException $e) {
            $this->flashMessage("Některé soubory se nepodařilo nahrát. " . $e->getMessage());
        }
    }

    /**
     * @desc new form submitted
     */
    public function formEditSubmitted(NSubmitButton $button) {
        try {
            $this->standardFormSubmitted($button, "Položka upravena.");
        } catch (IOException $e) {
            $this->flashMessage("Některé soubory se nepodařilo nahrát. " . $e->getMessage());
        }
    }

    // ======================================================


    function getAttrListValues(NAppForm $form, DependentSelectBox $dependentSelectBoxName) {
        $attr = $this->modelAttributes->find($this->model->getFieldIdFromName($dependentSelectBoxName->getName()));
        $parent_value = $form[$this->model->getFieldNameFromId($attr->parent_data_attribute)]->getValue();

        return $this->modelAttributes->getDependentListData($attr->id, $parent_value);
    }

    protected function createComponent($name) {

        switch ($name) {
            case "newActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addElement($this->link('default'), 'delete', 'zrušit');
                return;
            case "itemActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addActionElement(new WebAction('edit', $this->model, $this, array('id' => $this->id)), 'edit', 'upravit položku');

                $menu->addActionElement(new WebAction('delete!', $this->model, $this, array('id' => $this->id, 'backlink' => 'default:default')), 'delete', 'smazat položku')
                        ->setConfirm("Opravdu chcete smazat tuto položku?");
                return;
            case 'defaultActions':
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addActionElement(new WebAction('new', $this->model, $this), 'add', 'přidat položku do knihovny');

                return;
            case "itemView":
                $view = new DataBoxesView($this, $name);
                $view->setData($this->model->getItem($this->id));
                return;
            case 'formNew':
            case 'formEdit':
                $form = new MyForm($this, $name);

                $type = $name === 'formNew' ? $this->id : $this->model->find($this->id)->type_id;

                $form->addSubmit('ok', 'uložit')->onClick[] = array($this, $name === 'formNew' ? 'formSubmitted' : 'formEditSubmitted');
                $form['ok']->getControlPrototype()->class = 'right';

                $form->addGroup('název');

                $form->addText('name', 'Název položky', 40)
                        ->setRequired("Zadejte název položky.");

                foreach ($this->modelAttributesGroups->getGroups($type) as $group) {
                    $form->addGroup($group->name);

                    $group_controls = array();

                    foreach ($this->modelAttributes->findInGroup($group->id) as $attr) {

                        $fieldName = $this->model->getFieldNameFromId($attr->id);

                        switch ($attr->type) {
                            case AttributesModel::FIELD_SELECT:
                                if (!empty($attr->parent_data_attribute)) {
                                    $control = $form->addDependentSelectBox($fieldName, $attr->name, $group_controls[$attr->parent_data_attribute], array($this, 'getAttrListValues'));

                                    if ($this->isAjax())
                                        $control->addOnSubmitCallback(array($this, "invalidateControl"), "formSnippet");
                                } else {
                                    $control = $form->addSelect($fieldName, $attr->name, $this->modelAttributes->getListData($attr->id));
                                }
                                break;
                            case AttributesModel::FIELD_CHECKBOX:
                                $control = $form->addCheckbox($fieldName, $attr->name);
                                break;
                            case AttributesModel::FIELD_DATE:
                                $control = $form->addDatePicker($fieldName, $attr->name);
                                break;
                            case AttributesModel::FIELD_TEXT:
                            default:
                                $control = $form->addText($fieldName, $attr->name);
                                break;
                        }

                        if ($attr->description) {
                            $form->addQuickHelp($control, $attr->description);
                        }

                        if ($attr->required)
                            $control->setRequired($attr->name . " je povinný údaj.");

                        $group_controls[$attr->id] = $control;
                    }
                }

                $form->addGroup();
                $form->addTextArea('note', 'Poznámka', 65, 3);

                $form->addGroup('soubory');
                $form->addMultipleFileUpload('upload', 'soubory');

                $form->setCurrentGroup();

                //$form['ok']->getControlPrototype()->class = "right";

                $form->addSubmit('cancel', 'Storno')
                                ->setValidationScope(false)
                        ->onClick[] = array($this, 'formCanceled');


                $form->addHidden('type_id');

                if ($name === "formEdit")
                    $form->addHidden('id');

                $form->setHandle($this->model, $name === "formNew" ? 'insert' : 'update');
                break;
            case "tableChooseType":
                $table = new ListManualTable($this, $name);

                foreach ($this->modelTypes->dataSource() as $type) {
                    $table->addRow();
                    $table->addData(NHtml::el('h3')->setHtml(NHtml::el('a')->href($this->link('new', array('id' => $type->id)))
                                            ->setText($type->name)));
                }
                return;
            case "tableItemDetails":
                $dataView = new DataTableView($this, $name);
                return;
            case "fileTableEdit":
            case "fileTable":
                $table = new DsTable($this, $name);
                $table->setDataSource($this->modelFiles->dataSource($this->id, 'item_id'))
                        ->addColumn('name', 'název souboru');

                if ($name === "fileTableEdit") {
                    $table->addActionPrototype(new WebAction('deleteFile!', $this->modelFiles))
                            ->addActionArgPrototype(array('id' => 'id'))
                            ->setIconName('delete')
                            ->setIconTitle('smazat')
                            ->setConfirmMessage("Opravdu chcete smazat tento soubor?")
                            ->setAjax();
                }


                if ($name === "fileTable") {
                    $table->addColumn('size', 'velikost');

                    $table->addActionPrototype(new WebAction('file:download', $this->modelFiles))
                            ->addActionArgPrototype(array('id' => 'id'))
                            ->setIconName('download')
                            ->setIconTitle('stáhnout');
                }

                return;
            case "infoPanel":
                //$a = new QuickMenu($this, $name);

                $item = $this->modelItems->find($this->id);

                $table = new DataTableView($this, $name);

                $data = new GroupList();
                $data->addGroup()
                        ->addData($item->user_name . " " . $item->user_surname, 'vlastník');

                $data->addGroup()
                        ->addData($item->type_name, 'typ');

                $data->addGroup()
                        ->addData(Utils::getNiceDatetime($item->datetime_insert), 'vloženo');

                $data->addGroup()
                        ->addData(Utils::getNiceDatetime($item->datetime_edit), 'poslední změna');

                $table->setData($data);
                return;

            /* 		case "formChangeType":
              $form = new MyForm($this, $name);
              $form->onSubmit[] = array($this, 'changeType');

              $form->addGroup();

              $form->addSelect('type','Zvolte typ položky:', $this->modelTypes->getTypesArray())->controlPrototype->onchange("submit();");
              return; */
            default:
                parent::createComponent($name);
                return;
        }
    }

}

/*        if (substr($name, 0, 3) == 'frm') {

  $typeId = substr($name, 4);

  try {
  $type = $this->modelTypes->find($typeId);

  $form = new MyForm($this, $name);

  $form->addGroup();

  $form->addText('name', 'název')
  ->addRule(Form::FILLED, "Vyplňte pole 'název'");

  $groups = $this->modelAttributesGroups->getGroups($type->id);

  foreach ($groups as $child) {
  $form->addGroup();

  $this->recursiveFormFactory($this->modelAttributes->getAttributesTree($child->id), $form);
  }

  $form->addGroup();

  $form->addTextArea('note', 'poznámka', 60, 3);

  $form->addGroup();

  $form->addMultipleFileUpload("files", "soubory (max. 100)", 100)
  ->addRule("MultipleFileUpload::validateFileSize", "Soubory jsou dohromady moc veliké!", 209715200); // 1 KB

  $form->addHidden('type_id');

  $form->setCurrentGroup();


  if (substr($name, 3, 1) == 'N') {

  $form->addSubmit('ok', 'uložit')
  ->onClick[] = array($this, 'formNewSumbitted');
  } else {

  $form->addHidden('id');
  $form->addSubmit('ok', 'uložit')
  ->onClick[] = array($this, 'formEditSumbitted');
  }

  $form->addSubmit('cancel', 'zrušit')
  ->setValidationScope(null)
  ->onClick[] = array($this, 'frmCanceled');
  } catch (NotFoundException $e) {

  }
  return;
  } */
