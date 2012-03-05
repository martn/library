<?php

require_once dirname(__FILE__) . '/Sortable/SortableTreeModel.php';

//require_once LIBS_DIR . '/MyLib/ISortableTreeModel.php';

class AttributesModel extends SortableModel {
    const FIELD_TEXT = 'text';
    const FIELD_SELECT = 'select';
    const FIELD_CHECKBOX = 'checkbox';
    const FIELD_DATETIME = 'datetime';
    const FIELD_DATE = 'date';

   // private $selectIds;

    
    /**
     * (non-PHPdoc)av
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_ATTRIBUTES;
    }

    // ============ ISortableModel
    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Sortable/ISortableModel#getSortableDataSource($id)
     */
    public function getSortableDataSource($id) {
        try {
            $data = $this->getSortableRecord($id);

            return $this->findInGroup($data['group_id']);
        } catch (NotFoundException $e) {
            //throw $e;
        }
    }

    /**
     * @desc overriding method
     */
    public function reOrder($some_id) {
        parent::reOrder($some_id);

        $group_id = $this->find($some_id)->group_id;

        //    print_r($group_id.' is ordered: '.$this->isOrderedProperly($group_id));

        while (!$this->isOrderedProperly($group_id)) {



            foreach ($this->findInGroup($group_id) as $attr) {
                // if founds, that a parent_data_attribute has higher ord value, switch them.

                if (!empty($attr->parent_data_attribute)) {

                    $parent = $this->find($attr->parent_data_attribute);

                    if ($parent->ord > $attr->ord)
                        $this->placeBefore($parent->id, $attr->id);
                }
            }
        }
    }

    function isOrderedProperly($group_id) {
        return dibi::select('*')->from($this->getTable())->as('table1')
                ->join($this->getTable())->as('table2')->on('table1.id=table2.parent_data_attribute')
                ->where('table1.ord>table2.ord')
                ->where('table2.group_id=%i', $group_id)
                ->count() == 0;
    }

    function findInGroup($group_id) {
        return $this->dataSource($group_id, 'group_id');
    }

    /**
     * @desc returns array of possible field (attribute) types
     */
    public function getFieldTypes() {
        return array(self::FIELD_TEXT => 'textové pole',
            self::FIELD_SELECT => 'seznam položek',
            self::FIELD_CHECKBOX => 'zaškrtávací pole',
            self::FIELD_DATE => 'datum');
    }


    
    public function getTypeNameFromAbbr($abbr) {
        $types = $this->getFieldTypes();
        return $types[$abbr];
    }



    function getDataAbbr($dataId) {
        return dibi::select('abbr')
                ->from(self::TABLE_ATTR_LIST_ITEMS)
                ->where('id=%i', $dataId)
                ->fetchSingle();
    }

    /**
     * @desc returns sql column type acc to type_id
     */
/*    private function getColumnType($type_id) {
        switch ($type_id) {
            case self::FIELD_CHECKBOX:
                return 'boolean';
            case self::FIELD_SELECT:
                return 'integer';
            case self::FIELD_TEXT:
            default:
                return 'varchar(255)';
        }
    }*/

    public function getTypeName($columnType) {
        $types = $this->getFieldTypes();
        return $types[$columnType];
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#isActionPossible($action)
     */
    function isActionPossible(IAction $action) {
        $args = $action->getArgs();

        if (isset($args['fieldId']))
            $args['id'] = $args['fieldId'];
        if (isset($args['attr_id']))
            $args['id'] = $args['attr_id'];

        switch ($action->getName()) {
            case 'fieldData':
            case 'updateAttributeData':
                $attr = $this->find($args['id']);
                if ($attr->type !== self::FIELD_SELECT)
                    return false;
            case 'deleteField':
            case 'delete':
            case 'edit':
            case 'definition':
            case 'moveUp':
            case 'moveFieldUp':
            case 'moveFieldDown':
            case 'moveDown':
            case 'editField':
                if (!$this->exists($args['id']))
                    return false;
                break;
            case 'insert':
                $modelTypes = new TypesModel();
                if (!$modelTypes->exists($args['type_id']))
                    return false;
            default:
                break;
        }
        return $this->userAllowed('types', 'edit');
    }


    
    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#insert($args)
     */
    function insert(array $args, $table = null) {

        if ($args['group_id'] == 0) {
            $m = new AttributesGroupsModel();
            $args['group_id'] = $m->insert(array('name' => $args['group_name']));
            $m->linkToType($args['group_id'], $args['type_id']);
        }

        // postgre auto_increment column insert fix
        if (isset($args['id']))
            unset($args['id']);
        if (isset($args['type_id']))
            unset($args['type_id']);
        if (isset($args['group_name']))
            unset($args['group_name']);

        return parent::insert($args);
    }

    function update(array $args, $table = null) {

        if (isset($args['group_id']))
            if ($args['group_id'] == 0) {
                $m = new AttributesGroupsModel();
                $args['group_id'] = $m->insert(array('name' => $args['group_name']));
                $m->linkToType($args['group_id'], $args['type_id']);
            }

        //  print_r($args);
        // postgre auto_increment column insert fix
        if (isset($args['type_id']))
            unset($args['type_id']);
        if (isset($args['group_name']))
            unset($args['group_name']);

        return parent::update($args, $table);
    }

    public function delete($id, $table = null) {
        foreach ($this->dataSource($id, 'parent_data_attribute') as $attr) {
            // set all childs to not having any parent

            $this->update(array('id' => $attr->id, 'parent_data_attribute' => NULL));

            // set all data not to have any parents (to prevent their automatic deleting through foreign keys)
            dibi::update(self::TABLE_ATTR_LIST_ITEMS, array('parent_id' => NULL))
                    ->where('attr_id=%i', $attr->id)
                    ->execute();
        }
        return parent::delete($id, $table);
    }

    /**
     * @desc adds data to attribute (list)
     */
    public function addAttributeData($data) {
        if ($this->exists($data['attr_id'])) {

            $data = array('attr_id' => $data['attr_id'],
                'abbr' => $data['abbr'],
                'value' => $data['value'],
                'parent_id' => $data['parent_id']);

            dibi::insert(self::TABLE_ATTR_LIST_ITEMS, $data)
                    ->execute();

            return dibi::insertId();
        }
    }

    /**
     * @desc deletes data item of attribute
     */
    public function deleteAttributeData($dataId) {
        $data = dibi::select('*')->from(self::TABLE_ATTR_LIST_ITEMS)
                        ->where('id=%i', $dataId)
                        ->fetch();

        parent::delete($dataId, self::TABLE_ATTR_LIST_ITEMS);
    }

    private function countDataWithParent($attr_id) {
        return dibi::select('*')->from(self::TABLE_ATTR_LIST_ITEMS)
                ->where('attr_id=%i', $attr_id)
                ->where('parent_id IS NOT NULL')->count();
    }


    
    function processUpdateAttributeData(array $formData) {

        foreach ($formData as $key => $value) {

            $name_array = explode("_", $key);
            if (count($name_array) > 2) {
                if ($name_array[0] === "fd" & $name_array[1] === "key") {
                    $dataId = $name_array[2];

                    if ($formData['fd_chk_' . $dataId]) {
                        $this->deleteAttributeData($dataId);
                    } else {

                        $this->updateAttributeData($dataId,
                                array('abbr' => $value,
                                    'value' => $formData['fd_val_' . $dataId],
                                    'parent_id' => $formData['fd_par_' . $dataId]));

                    }
                }
            }
        }

        if ($formData['abbr'] != '' & $formData['value'] != '')
            $this->addAttributeData($formData);

        $this->correctParentDataAttribute($formData);
        $this->cleanupParentDataAttribute($formData);

        //print_r(" attr_od: ".$formData['attr_id']);
        $this->reOrder($formData['attr_id']);
    }

    
    /**
     * @desc updates data af attribute (list), dataId (id of data item)
     */
    public function updateAttributeData($dataId, $data) {

        return dibi::update(self::TABLE_ATTR_LIST_ITEMS, $data)
                ->where('id=%i', $dataId)
                ->execute();
    }

    /**
     * corrects parent_data_attribute field according to give form data
     * @param <type> $data
     */
    private function correctParentDataAttribute($data) {
        //print_r("corecting... ")
        if (empty($this->find($data['attr_id'])->parent_data_attribute) & !empty($data['parent_data_attribute'])) {
            parent::update(array('id' => $data['attr_id'], 'parent_data_attribute' => $data['parent_data_attribute']));
        }
    }

    private function cleanupParentDataAttribute($data) {
        if ($this->countDataWithParent($data['attr_id']) === 0) {
           // FirePHP::fireLog("zero...");
            parent::update(array('id' => $data['attr_id'], 'parent_data_attribute' => NULL));
        }
    }

    /**
     *
     * @param $attr_id
     * @param $selectedAttr
     * @param $selectedData
     * @return unknown_type
     */
    public function getFormListData($attr_id, $selectedAttr = null, $selectedData = null) {
        if ($this->isRoot($attr_id)) {
            return $this->getListData($attr_id);
        } else {
            // not root, has parent, must be restricted or empty

            if ($selectedParentAttr !== null & $selectedParentData !== null) {
                
            } else {
                // first stage...

                return $this->getEmptyListData($attr_id);
            }
        }
    }

    /**
     * returns previously selected value of selectbox attribute
     * @param $attr_id
     * @return unknown_type
     */
    public function loadSelectedValue($attr_id) {

    }

    /**
     *
     * @param unknown_type $attr_id
     * @param unknown_type $value
     * @return unknown_type
     */
    public function saveSelectedValue($attr_id, $value) {

    }

    /**
     * returns list data with just non-restricted items
     * @param unknown_type $attr_id
     * @return array
     */
    private function getEmptyListData($attr_id) {
        $ds = dibi::dataSource('select *
				from [' . self::TABLE_ATTR_LIST_ITEMS . ']
				where attr_id=%i', $attr_id, '
				and parent_id=0');

        return $this->selectBoxDataFromDatasource($ds);
    }

    /**
     * @desc returns selectbox array from data items datasource
     * @param DibiDataSource $ds
     * @return unknown_type
     */
    private function selectBoxDataFromDatasource(DibiDataSource $ds) {
        $ret = array();
        foreach ($ds as $item) {
            $ret[$item->id] = $item->value;
        }
        return $ret;
    }

    /**
     * returns list data with items restricted by parent_id UNION non-restricted items
     * @param unknown_type $attr_id
     * @param unknown_type $parent_id
     * @return array
     */
    private function getRestrictedListData($attr_id, $parent_id) {
        $ds = dibi::dataSource('select * from (select *
				from [' . self::TABLE_ATTR_LIST_ITEMS . ']
				where attr_id=%i', $attr_id, ') as sel
				where parent_id=%i', $parent_id, '
				union select * from sel
				where parent_id=0');
        return $this->selectBoxDataFromDatasource($ds);
    }

    /**
     * test if $potChild is in chain of childs
     * @param <type> $id
     * @param <type> $potChild
     */
    private function attrInChildChain($id, $potChild) {
        $record = $this->find($potChild);

        if (empty($record->parent_data_attribute)) {

            //        print_r(" parent is empty.");

            return false;
        } elseif ($record->parent_data_attribute === $id) {

            //          print_r(" parent is ID ");

            return true;
        } else {

//            print_r(" going deeper.... ");
            return $this->attrInChildChain($id, $record->parent_data_attribute);
        }
    }

    function getRelevantDependableAttributesList($id) {
        $attr = $this->find($id);

        if (empty($attr->parent_data_attribute)) {

            $arr = array(NULL => '--------------');

            foreach (dibi::select('id, name')
                    ->from($this->getTable())
                    ->where('group_id=%i', $attr['group_id'])
                    ->where('type=%s', self::FIELD_SELECT)
                    ->where('id<>%i', $id)
                    ->fetchPairs('id', 'name') as $id_value => $name) {

                //        print_r(' | '.$id.' id: ' . $id_value);

                if (!$this->attrInChildChain($id, $id_value)) {
                    $arr[$id_value] = $name;
                }
            }

            return $arr;
            /*
              return array_combine(array_merge(array(NULL), array_keys($arr)),
              array_merge(array('-----------'), array_values($arr)));
             */
        } else {

            // return just parent attribute

            return $arr = dibi::select('id, name')
                    ->from($this->getTable())
                    ->where('id=%i', $attr->parent_data_attribute)
                    ->fetchPairs('id', 'name');
        }
    }

    function getDependentListData($id, $parent_value) {
        return dibi::dataSource("select id, value
                            from " . self::TABLE_ATTR_LIST_ITEMS . "
                        where attr_id=$id and parent_id=$parent_value
                        union select id, value
                            from " . self::TABLE_ATTR_LIST_ITEMS . "
                        where attr_id=$id and parent_id IS NULL")
                ->fetchPairs('id', 'value');
        /*
          $arr = array();
          foreach ($res as $data) {
          $arr[$data->id] = $data->name;
          }
          return $arr; */
    }

    /**
     * @desc returns data array acc to attr id
     */
    public function getListData($id, $extended = false) {
        if ($extended) {
            return dibi::select('*')
                    ->from(self::TABLE_ATTR_LIST_ITEMS)
                    ->where('attr_id=%i', $id);
        } else {
            //array(0 => 'kozy');
            $res = dibi::select('id, value')
                            ->from(self::TABLE_ATTR_LIST_ITEMS)
                            ->where('attr_id=%i', $id)
                            ->fetchPairs('id', 'value');
            return Utils::addEmptyRowToArray($res);
        }
    }

    /**
     * @desc returns list data of parent attribute
     * @param unknown_type $id
     * @return unknown_type
     */
    public function getListDataOfParent($id) {
        $ar = array(0 => '................');
        try {
            $ret = $this->getListData($this->find($id)->parent_id);
            return array_merge($ret, $ar);
        } catch (NotFoundException $e) {
            return $ar;
        }
    }

    /**
     * @desc update attribute from data
     */
    /*    public function updateAttribute($data, $typeId) {

      try {
      $a = $this->find($data['id']);

      $m = new AttributesGroupsModel();

      if ($data['group_id'] != $a['group_id']) { // change group
      if ($data['group_id'] == 0) {
      $data['group_id'] = $m->newGroup($typeId, $data['name']);
      }

      $data['parent_id'] = 0;
      $this->changeGroup($data['id'], $data['group_id']);
      }

      $this->update($data);
      $m->sweepGroup($a['group_id']);

      $this->reOrder($a['parent_id']);

      $this->reOrder($data['id']);
      } catch (NotFoundException $e) {

      }
      } */

    /**
     * changes group of attribute tree given root id
     * @param unknown_type $id
     * @param unknown_type $groupId
     * @return unknown_type
     */
    /*   protected function changeGroup($id, $groupId) {
      $this->update(array('id' => $id, 'group_id' => $groupId));

      foreach ($this->getChilds($id) as $child) {
      $this->changeGroup($child->id, $groupId);
      }
      } */

    /**
     * @desc returns column name acc to id
     */
    /* 	public function getColName($id) {
      return 'f_'.$id;
      } */




    /**
     * @desc returns select abbr from id
     */
    /* 	public function getSelectAbbr($id)
      {
      return dibi::select('abbr')->from(self::TABLE_ATTR_LIST_ITEMS)->where('id=%i',$id)->fetchSingle();
      } */



    /**
     * @desc returns select value from id
     */
    /* 	public function getSelectValue($id)
      {
      return dibi::select('value')->from(self::TABLE_ATTR_LIST_ITEMS)->where('id=%i',$id)->fetchSingle();
      } */

    /**
     * @desc returns attributes ids of type SELECT
     */
    /* 	public function getSelectsIds()
      {
      if(empty($this->selectIds)) $this->updateSelectsIds();
      return $this->selectIds;
      } */

    /*
      function getAjaxSelectData($typeId, $fid = NULL) {
      $m = new AttributesGroupsModel();

      $ret = array();
      foreach ($m->getGroups($typeId) as $group) {
      $data = $this->getAttributesTree($group->id)->getFormArray($fid);
      unset($data[0]);
      $ret[$group->id] = $data;
      }
      return $ret;
      } */
}