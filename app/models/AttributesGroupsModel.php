<?php

require_once dirname(__FILE__) . '/Sortable/SortableModel.php';

class AttributesGroupsModel extends SortableModel {

    function __construct($id = NULL) {
        parent::__construct();

        $this->setId($id);
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_ATTRIBUTES_GROUPS;
    }

    // ============ ISortableModel

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Sortable/ISortableModel#getSortableDataSource($id)
     */
    public function getSortableDataSource($link_id) {

        try {

            $data = $this->getSortableRecord($link_id);

            return dibi::select('ord, id')
                    ->from($this->getSortableTable())
                    ->where('type_id=%i', $this->getId())
                    ->orderBy('ord');
        } catch (NotFoundException $e) {
            throw $e;
        }
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Sortable/ISortableModel#getSortableRecord($id)
     */
    public function getSortableRecord($link_id) {
        return dibi::select('*')->from($this->getSortableTable())
                ->where('id=%i', $link_id)
                ->fetch();
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Sortable/ISortableModel#getSortableTable()
     */
    public function getSortableTable() {
        return self::TABLE_TYPES_ATTRIBUTES_GROUPS;
    }

    //=====================================

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Sortable/SortableModel#dataSource($value, $column, $context, $table)
     */
    public function dataSource($value = null, $column = 'id', $context = 'i', $table = null) {
        $res = dibi::select('groups.*,
    				t_a_g.type_id,
    				t_a_g.id as link_id,
    				t_a_g.ord as ord')
                        ->from($this->getTable())->as('groups')
                        ->join(self::TABLE_TYPES_ATTRIBUTES_GROUPS)->as('t_a_g')
                        ->on('groups.id=t_a_g.group_id')
                        ->toDataSource()
                        ->orderBy('ord');

        //if(!empty ($this->))
        if ($this->getId() !== NULL) {
            $res = $res->where('type_id=%i', $this->getId());
        }

        if ($value == null) {
            return $res;
        } else {
            return $res->where($column . '=%' . $context, $value);
        }
    }

    /**
     * @desc returns datasource of groups according to given typeId
     * @param $typeId
     * @return DibiDataSource
     */
    public function getGroups($typeId = NULL) {
        return $this->dataSource(empty($typeId) ? $this->getId() : $typeId, 'type_id');
    }

    function getGroupsSelectData($typeId) {
        $ret = array(0 => 'založit skupinu ->');
        foreach ($this->getGroups($typeId) as $group) {
            $ret[$group->id] = $group->name;
        }
        return $ret;
    }

    //==========================================

    /**
     * @desc links group to type
     * @param $groupId
     * @param $typeId
     * @return unknown_type
     */
    public function linkToType($groupId, $typeId) {
        dibi::insert(self::TABLE_TYPES_ATTRIBUTES_GROUPS, array('group_id' => $groupId,
                    'type_id' => $typeId))
                ->execute();

        $lId = dibi::insertId();
        $this->reOrder($lId);

        return $lId;
    }

    /**
     * @desc de facto deletes group, if doesn't contain another attribute.
     * @param $groupId
     * @param $attrId
     * @return unknown_type
     */
    public function sweepGroup($groupId) {
        $m = new AttributesModel();
        if ($m->dataSource($groupId, 'group_id')->count() == 0) { // no more attributes in group
            $this->delete($groupId);
        }
    }

    /**
     * @desc returns all links according to group id
     * @param unknown_type $groupId
     * @return DibiDataSource
     */
    public function getGroupLinks($groupId) {
        return dibi::select('t_a_g.*, t.name')
                ->from(self::TABLE_TYPES)->as('t')
                ->join(self::TABLE_TYPES_ATTRIBUTES_GROUPS)->as('t_a_g')
                ->on('t_a_g.type_id=t.id')
                ->where('t_a_g.group_id=%i', $groupId)
                ->toDataSource();
    }

    public function processRemoveGroup(array $args) {
        return $this->removeFromType($args['id'], $args['type_id']);
    }

    /**
     * @desc removes group from type (and deletes it if not linked to other types)
     * @param unknown_type $linkId
     * @return unknown_type
     */
    public function removeFromType($groupId, $typeId) {
        dibi::delete(self::TABLE_TYPES_ATTRIBUTES_GROUPS)
                ->where('group_id=%i', $groupId)
                ->where('type_id=%i', $typeId)
                ->execute();

        $groupLinks = parent::dataSource($groupId, 'group_id', 'i', self::TABLE_TYPES_ATTRIBUTES_GROUPS);

        if ($groupLinks->count() == 0) {
            $this->delete($groupId);
        } else {
            $this->reOrder($groupLinks->fetch()->id);
        }
    }

    /**
     * shares or removes sharing on a group,
     * returns 0 on success or list of types sharing it
     * @param $groupId
     * @return 0, DibiDataSource
     */
    public function toggleGroupSharing($groupId) {

        $links = $this->getGroupLinks($groupId);

        if ($links->count() > 1) {
            return $links;
        } else {

            try {
                $group = $this->find($groupId);

                $this->update(array('id' => $groupId,
                    'shared' => !$group->shared));
            } catch (NotFoundException $e) {
                throw $e;
            }

            return 0; // success
        }
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#isActionPossible($action)
     */
    function isActionPossible(IAction $action) {
        $args = $action->getArgs();

        if (isset($args['groupId']))
            $args['id'] = $args['groupId'];

        switch ($action->getName()) {
            case 'removeGroup':
                $types = new TypesModel();
                if (!$types->exists($args['type_id']))
                    return false;
            case 'delete':
            case 'editGroup':
            case 'update':
                if (!$this->exists($args['id']))
                    return false;
                break;
            case 'moveGroupUp':
            case 'moveGroupDown':
                if (!$this->exists($args['id'], 'id', 'i', self::TABLE_TYPES_ATTRIBUTES_GROUPS))
                    return false;
            default:
                break;
        }
        return $this->userAllowed('types', 'edit');
    }

    /**
     * @desc returns shared groups available for type according to typeId
     * returns all shared groups, if no typeId presented
     * @param unknown_type $typeId
     * @return DibiDataSource
     */
    public function getSharedGroups($typeId) {
        return dibi::dataSource('select *
    				FROM [' . self::TABLE_ATTRIBUTES_GROUPS . ']
    				where 
    				id NOT IN (SELECT group_id as id
    					FROM [' . self::TABLE_TYPES_ATTRIBUTES_GROUPS . ']
    					WHERE type_id = %i', $typeId, ')');
    }

    function update(array $args, $table = null) {
        unset($args['type_id']);
        return parent::update($args, $table);
    }

    function insert(array $args, $table = null) {
        $typeId = $args['type_id'];
        unset($args['type_id']);

        $types = new TypesModel();
        if ($types->exists($typeId)) {

            $groupId = parent::insert($args, $table);

            $this->linkToType($groupId, $typeId);

            return $groupId;
        } else {
            throw new ActionNotPossibleException();
        }
    }

}