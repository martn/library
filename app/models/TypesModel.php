<?php

require_once dirname(__FILE__) . '/Sortable/SortableModel.php';

//require_once dirname(__FILE__) . '/DataStructures/IRenderableGroupTree.php';
/**
 * Users authenticator.
 */
class TypesModel extends SortableModel {

    private $selects;
    private $modelAttributes;
    private $modelAttributesGroups;

    
    /**
     * @desc constructor
     */
    public function __construct($id = NULL) {
        parent::__construct();

        $this->setId($id);

        $this->modelAttributes = new AttributesModel();
        $this->modelAttributesGroups = new AttributesGroupsModel($id);
    }

    
    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_TYPES;
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#isActionPossible($action)
     */
    function isActionPossible(IAction $action) {
        $args = $action->getArgs();

        //if(isset($args['form'])) $args = $args['form']->getValues();

        switch ($action->getName()) {
            case 'editField':
                if(!$this->modelAttributes->exists($args['fieldId']))
                     return false;
                break;
            case 'addField':
                if(!empty($args['groupId']))
                if(!$this->modelAttributesGroups->exists($args['groupId']))
                     return false;
            case 'delete':
            case 'edit':
            case 'addSharedGroups':
            case 'definition':
            case 'signature':
            case 'updateSignature':
                if (!$this->exists($args['id']))
                    return false;
                break;

            default:
                break;
        }
        return $this->userAllowed('types', 'edit');
    }


    function processUpdateSignature($args) {
        $this->update($args);
    }

    

    public function processAddSharedGroups($data) {
        foreach ($this->modelAttributesGroups->getSharedGroups($data['id']) as $group) {
            if ($data['group' . $group->id]) {
                $this->modelAttributesGroups->linkToType($group->id, $data['id']);
            }
        }
    }

    /**
     * returns type field definition 
     * @param integer $id
     * @return GroupTree
     */
    function getDefinition() {
        $groupDataList = new GroupDataList();

        foreach ($this->modelAttributesGroups->getGroups() as $group) {
            $groupDataList->addGroup($this->modelAttributes->findInGroup($group->id), $group);
        }

        return $groupDataList;
    }



    function getSelectBoxAttributes($id) {
        return dibi::select('attr.*')
                    ->from(self::TABLE_TYPES_ATTRIBUTES_GROUPS)->as('t_a_g')
                    ->join(self::TABLE_ATTRIBUTES_GROUPS)->as('a_g')->on('t_a_g.group_id=a_g.id')
                    ->join(self::TABLE_ATTRIBUTES)->as('attr')->on('a_g.id=attr.group_id')
                    ->where('attr.type=%s',  AttributesModel::FIELD_SELECT)
                    ->where('t_a_g.type_id=%i',$id)
                    ->toDataSource();
    }


    /**
     * @desc returns types array id->name
     */
    public function getTypesArray() {
        $ret = array();
        foreach ($this->find() as $item) {
            $ret[$item->id] = $item->name;
        }
        return $ret;
    }

    /**
     * returns true if type of given abbreviation exists
     * @param $abbr
     * @return unknown_type
     */
    public function typeExists($abbr) {
        return $this->exists($abbr, 'abbr', 's');
    }

// ===========================================================

    /**
     * @desc returns true if signature is valid , throws exception if not
     */
    public function formSignatureValid($sig, $id) {

        if(empty($sig)) return true;

        //
        if (strstr($sig, " ") != false) {
            throw new Exception("Chyba, definice nesmí obsahovat mezery.");
        }

        $sig_arr = explode("-", $sig);

        foreach ($sig_arr as $item) {
            if ($item == "") {
                throw new Exception("Chyba v definici.");
            }

            if (!is_numeric($item)) {
                throw new Exception("Chyba, prvky musí být jen čísla.");
            } else {

                if (!$this->hasAttribute($id, $item)) {
                    throw new Exception("Chyba, špatné identifikační číslo pole " . $item);
                }
            }
        }
        return true;
    }

    
    /**
     * @desc returns true if signature is valid
     */
    public function signatureValid($sign) {
        $sign = trim($sign);

        $sign_arr = explode("-", $sign);

        if (!is_numeric(end($sign_arr)))
            return false;

        $abbrFromSig = $sign_arr[count($sign_arr) - 2];

        if (!$this->typeExists($abbrFromSig))
            return false;

        $type = $this->find($abbrFromSig, "abbr", "s");

        $def_arr = explode("-", $type->signature);

        if (count($sign_arr) - 2 == count($def_arr)) {  // could be a candidate
            return true;
        } else {
            return false;
        }
    }

    /**
     * @desc returns columns array from signature definition
     */
    public function getColumnsIdFromSigDef($sigDef) {
        if ($sigDef == "") {
            return array();
        } else {
            return explode("-", $sigDef);
        }
    }

    /**
     * @desc returns signature from given item data
     */
    public function getSignature($data) {
        $ret = '';
        $model = new ItemsModel();
       // $item = $model->find($data['id']);

        foreach ($this->getColumnsIdFromSigDef($data['signature_definition']) as $colId) {
            $ret .= $this->modelAttributes->getDataAbbr($model->getItemAttrData($data['id'], $colId)->integer) . '-';
        }
        return strtoupper($ret . $data['type_abbr'] . '-' . $data['id']);
    }

    /**
     * @desc returns array of groups according to given type id
     * @param $id
     * @return unknown_type
     */
    function getSelectboxGroupArray($id) {
        $ret = array();

        $res = dibi::select('attr_group_id as id')
                        ->from(self::TABLE_TYPES_ATTRIBUTES_GROUPS)
                        ->where('type_id=%i', $id);


        foreach ($res as $group) {
            $ret[$group->id] = dibi::select('name')
                            ->from(self::TABLE_ATTRIBUTES)
                            ->where('parent_id=0')
                            ->where('group_id=%i', $group->id)
                            ->orderBy('id')
                            ->fetchSingle();
        }

        return $ret;
    }

    /**
     * @desc returns array of attributes to match the record from signature
     */
    public function getAttributesFromSignature($sign) {
        $itemsModel = new ItemsModel();

        $sign_arr = explode("-", trim($sign));

        $id = end($sign_arr);
        if (!$this->signatureValid($sign))
            throw new BadFormatException();

        try {
            $item = $itemsModel->find($id);
        } catch (NotFoundException $e) {
            
        }


        throw new NotFoundException();
    }

    /**
     * @desc returns signature definitions in array type_id=>definition
     */
    public function getSignatureDefinitions() {
        return dibi::select("id, signature")
                ->from(self::TABLE_TYPES)
                ->fetchAssoc("id");
    }


    
    /**
     * @desc returns true if specified type has specified attribute.
     * if $attr_id not specified - returns true if has at least one attribute.
     */
    public function hasAttribute($id, $attr_id = 0) {

        if($this->getSelectBoxAttributes($id)->where('id=%i',$attr_id)->count() > 0) {
            return true;
        } else {
            return false;
        }

        /*
        $qu = dibi::select('t_a_g.id')->from(self::TABLE_TYPES_ATTRIBUTES_GROUPS)->as('t_a_g');

        if ($attr_id == 0) { // no specific attribute
            if ($qu->where('type_id=%i', $id)->count() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $qu = $qu->join(self::TABLE_ATTRIBUTES_GROUPS)->as('groups')
                            ->on('t_a_g.attr_group_id=groups.id')
                            ->join(self::TABLE_ATTRIBUTES)->as('a')
                            ->on('groups.id=a.group_id')
                            ->where('a.id=%i', $attr_id);

            if ($qu->count() > 0) {
                return true;
            } else {
                return false;
            }
        }*/
    }

}

