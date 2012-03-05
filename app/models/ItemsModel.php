<?php

require_once dirname(__FILE__) . '/Base/BaseModel.php';

class ItemsModel extends BaseModel {

    private $modelTypes;
    private $modelAttributes;
    private $modelAttributesGroups;
    private $modelFiles;

    /**
     * @desc constructor
     */
    public function __construct() {
        parent::__construct();

        $this->modelTypes = new TypesModel();
        $this->modelAttributes = new AttributesModel();
        $this->modelAttributesGroups = new AttributesGroupsModel();
        $this->modelFiles = new FilesModel();
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_ITEMS;
    }

    function getItemAttrData($id, $attr_id) {
        return dibi::select('*')
                ->from(self::TABLE_ITEMS_DATA)
                ->where('item_id=%i', $id)
                ->where('attr_id=%i', $attr_id)
                ->fetch();
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#isActionPossible($action)
     */
    function isActionPossible(IAction $action) {
        $args = $action->getArgs();

        switch ($action->getName()) {
            case 'search':
                return $this->userAllowed('items', 'view');
            case 'new':
                if (isset($args['id']))
                    if (!$this->modelTypes->exists($args['id']))
                        return false;
                break;
            case 'edit':
            case 'update':
            case 'delete':
                if (!$this->exists($args['id'])) {
                    return false;
                } else {
                    return $this->isUserOwner($args['id']);
                }
                break;
            case 'detail':
                if (!isset($args['id']))
                    return false;
            case 'view':
                if ($this->userAllowed('items', 'view')) {
                    if (isset($args['id']))
                        if (!$this->exists($args['id']))
                            return false;
                    return true;
                } else {
                    return false;
                }
                break;
            default:
                break;
        }

        return $this->userAllowed('items', 'edit');
    }

    function isUserOwner($id) {
        return $this->find($id)->user_id == NEnvironment::getUser()->getIdentity()->data['id'];
    }

    /*
      function getFiles($id) {
      return $this->modelFiles->find()
      } */

    /**
     * returns true if user is allowed to view/download item
     * @param <type> $id
     */
    function isUserAllowedToHandle($id) {
        return $this->isUserOwner($id);
    }

    function getFieldNameFromId($fieldId) {
        return 'f' . $fieldId;
    }

    function getFieldIdFromName($fieldName) {
        return substr($fieldName, 1);
    }

    public function update(array $args, $table = null) {

        parent::update(array('datetime_edit' => dibi::datetime(),
            'note' => $args['note'],
            'name' => $args['name'],
            'id' => $args['id']));

        foreach ($this->modelAttributesGroups->getGroups($args['type_id']) as $group) {
            foreach ($this->modelAttributes->findInGroup($group->id) as $attr) {

                $data = array($this->getDataColumnFromType($attr->type)
                    => $args[$this->getFieldNameFromId($attr->id)]);

                if (isset($data['integer']) & empty($data['integer'])) {
                    $data['integer'] = NULL;
                }

                dibi::update(self::TABLE_ITEMS_DATA, $data)
                        ->where('attr_id=%i', $attr->id)
                        ->where('item_id=%i', $args['id'])
                        ->execute();
            }
        }

        $this->handleFiles($args, $args['id']);
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#insert($args, $table)
     */
    public function insert(array $args, $table = null) {

        $item = array('name' => $args['name'],
            'note' => $args['note'],
            'type_id' => $args['type_id']);

        $item['datetime_insert'] = dibi::datetime();
        $item['datetime_edit'] = dibi::datetime();
        $item['user_id'] = NEnvironment::getUser()->getIdentity()->data['id'];

        $itemId = parent::insert($item);

        foreach ($this->modelAttributesGroups->getGroups($args['type_id']) as $group) {
            foreach ($this->modelAttributes->findInGroup($group->id) as $attr) {
                $data = array('attr_id' => $attr->id,
                    'item_id' => $itemId);

                $attr_data = $args[$this->getFieldNameFromId($attr->id)];

                switch ($attr->type) {
                    case AttributesModel::FIELD_SELECT:
                        $data['integer'] = empty($attr_data) ? NULL : $attr_data;
                        break;
                    case AttributesModel::FIELD_CHECKBOX:
                        $data['boolean'] = $attr_data;
                        break;
                    case AttributesModel::FIELD_DATE:
                        $data['datetime'] = $attr_data;
                        break;
                    case AttributesModel::FIELD_TEXT:
                    default:
                        $data['string'] = $attr_data;
                        break;
                }

                parent::insert($data, self::TABLE_ITEMS_DATA);
            }
        }

        $this->handleFiles($args, $itemId);

        return $itemId;
    }

    private function handleFiles($args, $id) {
        foreach ($args['upload'] as $file) {
            if (!$file->getError() == UPLOAD_ERR_NO_FILE && !$file->isOk())
                throw new IOException('Chyba při kopírování souboru.');
            $this->modelFiles->addFile($id, $file);
        }
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#delete($id)
     */
    public function delete($id, $table = null) {
        foreach ($this->modelFiles->dataSource($id, 'item_id') as $file) {
            $this->modelFiles->delete($file->id);
        }
        parent::delete($id);
    }

    /**
     * @desc returns array(AttributesModel::FIELD_% => items_data column)
     * @return unknown_type
     */
    private function getAttrTypeToFieldArray() {
        return array(AttributesModel::FIELD_SELECT => 'integer',
            AttributesModel::FIELD_CHECKBOX => 'boolean',
            AttributesModel::FIELD_DATETIME => 'datetime',
            AttributesModel::FIELD_DATE => 'datetime',
            AttributesModel::FIELD_TEXT => 'string');
    }

    private function getDataColumnFromType($fieldType) {
        $array = $this->getAttrTypeToFieldArray();
        return $array[$fieldType];
    }

    /**
     * @desc returns part of the url
     * @param unknown_type $data
     * @return unknown_type
     */
    public function getItemUrl($data) {
        return str_replace(" ", "-", $this->removeSpecialCharacters($data['name'])) . "-" . $data['id'];
    }

    /**
     * @desc returns id from given item url
     * @param $url
     * @return unknown_type
     */
    public function getIdFromItemUrl($url) {
        $ar = explode("-", $url);
        return(end($ar));
    }

    /**
     * @desc retrieve specific record (all with
     */
//    public function find($value = null, $column = 'id', $context = 'i', $table = null) {
    //       return parent::find($value, $column, $context, $table);

    /*
      $res = $this->dataSource($value, $column, $context, $table);


      if ($res->count() == 0) {
      throw new NotFoundException();
      } elseif ($res->count() == 1) {
      $item = $res->fetch();

      // associative array[data_id] => data field
      $fieldArray = $this->getDataFieldArrayFromItemId($item->id);

      //print_r($fieldArray);
      //$fieldArray = $this->getAttrTypeToFieldArray();

      foreach ($this->getItemData($item->id) as $data) {

      $colName = $this->modelAttributes->getColName($data->attr_id);

      //				echo $colName.' '.$fieldArray[$data->id].' '.$data[$fieldArray[$data->id]].' ; ';
      $item->$colName = $data[$fieldArray[$data->id]];
      }

      return $item;
      } else {
      return $res;
      } */
    //}

    /**
     * returns item data for view
     * @param <type> $id
     */
    function getItem($id) {
        $item = $this->find($id);

        $groupList = new GroupList();
        // $groupList->addGroup('Název')->addData($item->name);

        foreach ($this->modelAttributesGroups->getGroups($item->type_id) as $group) {
            $gr = $groupList->addGroup($group->name);

            $result = dibi::select('attrs.name,
                              attrs.type,
                              data.*')->from(self::TABLE_ITEMS)->as('items')
                    ->join(self::TABLE_ITEMS_DATA)->as('data')
                    ->on('items.id=data.item_id')
                    ->join(self::TABLE_ATTRIBUTES)->as('attrs')
                    ->on('data.attr_id=attrs.id')
                    ->where('items.id=%i', $id)
                    ->where('attrs.group_id=%i', $group->id)
                    ->orderBy('attrs.ord');

            foreach ($result as $attr) {

                switch ($attr->type) {
                    case AttributesModel::FIELD_CHECKBOX:
                        $data = $attr->boolean ? "Ano" : "Ne";
                        break;
                    case AttributesModel::FIELD_SELECT:
                        $data = dibi::select('value')->from(self::TABLE_ATTR_LIST_ITEMS)
                                ->where('id=%i', $attr->integer)
                                ->fetchSingle();
                        break;
                    case AttributesModel::FIELD_DATE:
                        $data = Utils::getNiceDate($attr->datetime);
                        break;
                    case AttributesModel::FIELD_TEXT:
                    default:
                        $data = $attr->string;
                        break;
                }

                $gr->addData($data, $attr->name);
            }

            //     $groupList->addGroup('Poznámka')->addData($item->note);
        }

        return $groupList;
    }

    /**
     * @desc returns associative array of types, with data id as a key
     * @param unknown_type $itemId
     * @return unknown_type
     */
    /*    private function getDataFieldArrayFromItemId($itemId) {
      $types = dibi::select('i_d.id, a.type')
      ->from(self::TABLE_ATTRIBUTES)->as('a')
      ->join(self::TABLE_ITEMS_DATA)->as('i_d')
      ->on('a.id=i_d.attr_id')
      ->where('i_d.item_id=%i', $itemId)
      ->fetchAssoc('id');

      $fieldArray = $this->getAttrTypeToFieldArray();

      $arr = array();
      foreach ($types as $key => $data) {
      $arr[$key] = $fieldArray[$data->type];
      }
      return $arr;
      } */


    function getFilteredItems($values = array()) {

        if (empty($values['fts'])) {
            $dataSource = $this->dataSource();
        } else {
            $dataSource = $this->ftsDataSource($values['fts']);
        }

        
         
        
        // filter user
        if (isset($values['user_id'])) {
            if ($values['user_id'] != 0) {
                $dataSource = $dataSource->where('user_id=%i', $values['user_id']);
            }
        }
        

        
        $types = array();
        
        // filter types
        foreach ($this->modelTypes->dataSource() as $type) {
            if ($values['type' . $type->id]) {
                array_push($types, $type->id);
            }
        }
        
        $dataSource = $dataSource->where('type_id IN (%i)', $types);

        return $dataSource;
    }

    /**
     * returns datasource from fulltext search
     * @param type $keywords given search string
     * @return type 
     * 
     */
    private function ftsDataSource($keywords) {

        /**
         * create word1 | word2 | word3 .... string
         */
        $q_array = explode(" ", trim($keywords));
        $q = implode(" | ", $q_array);

        $res = dibi::dataSource("select ts_rank_cd(fts_index, q) as rank, 
                                items.*,
                                fts.fts_index as fts_index,
                                users.name as user_name,
    				users.surname as user_surname,
    				types.signature as signature_definition,
    				types.name as type_name,
    				types.abbr as type_abbr 
                            from " . self::TABLE_ITEMS . " as items 
                            join " . self::TABLE_ITEMS_FTS . " as fts on items.id=fts.id
                            join " . self::TABLE_USERS . " as users on users.id=items.user_id 
                            join " . self::TABLE_TYPES . " as types on types.id=items.type_id, 
                            to_tsquery('czech','$q') q 
                            where q @@ fts_index order by rank desc"); //->toDataSource();


        return $res;
    }

    /**
     * @desc returns data source of items
     */
    public function dataSource($value = null, $column = 'id', $context = 'i', $table = null) {
        $res = dibi::select('items.*,
    				  users.name as user_name,
    				  users.surname as user_surname,
    				  types.signature as signature_definition,
    				  types.name as type_name,
    				  types.abbr as type_abbr')
                ->from(self::TABLE_ITEMS)->as('items')
                ->join(self::TABLE_USERS)->as('users')->on('users.id=items.user_id')
                ->join(self::TABLE_TYPES)->as('types')->on('types.id=items.type_id')
                ->toDataSource();

        if ($value === null)
            return $res;

        return $res->where($column . '=%' . $context, $value);
    }

    /**
     * @desc returns datasource from keyword fulltext search
     * @param $keywords
     * @return DibiDataSource
     */
  /*  public function fulltextSearch($keywords) {
        $keywords = strtolower($keywords);

        return dibi::dataSource("
    		SELECT id
             	FROM (SELECT * FROM [" . self::TABLE_ITEMS . "]
             	WHERE LCASE(name) LIKE '%$keywords%') as items
                JOIN [" . self::TABLE_USERS . "] as users ON (users.id=items.user_id)
                JOIN [" . self::TABLE_TYPES . "] as types ON (types.id=items.type_id)
    	");
    }*/

    /**
     * @desc returns signature from given item data
     */
    public function getSignature($data) {
        return $this->modelTypes->getSignature($data);
    }

    /**
     * @desc returns id acc to given signature
     * @param unknown_type $sign
     * @return unknown_type
     */
    public function signatureToId($sign) {
        if ($this->modelTypes->signatureValid($sign)) {
            $ar = explode("-", $sign);
            return end($ar);
        } else {
            return 0;
        }
    }

    /**
     * @desc finds records acc. to signature
     */
    public function findFromSignature($sign) {
        try {
            return $this->find($this->signatureToId($sign));
        } catch (NotFoundException $e) {
            throw $e;
        }
    }

}
