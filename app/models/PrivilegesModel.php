<?php

require_once dirname(__FILE__) . '/Base/BaseModel.php';

class PrivilegesModel extends BaseModel {

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_PRIVILEGES;
    }

    /**
     * @desc returns privileges array (id, name)
     */
    public function getArray() {
        foreach ($this->find() as $val) {
            $arr[$val->id] = $val->name;
        }
        return $arr;
    }

    /**
     * @desc returns all groups
     */
    public function getGroups() {
        return dibi::select('*')->from(self::TABLE_GROUPS);
    }


    /**
     * @desc returns data for selectbox
     */
    public function getSelectBoxArray() {

        $ret = array();
        foreach ($this->getGroups() as $group) {
            $temp = array();
            foreach ($this->getRules($group->id) as $rule) {
                $temp[$rule->id] = $rule->name;
            }
            $ret[$group->name] = $temp;
        }
        return $ret;
    }


    /**
     * @desc returns array of all resources
     */
    public function getResourcesArray() {
        foreach ($this->find(null, 'id', 'i', self::TABLE_RESOURCES) as $val) {
            $arr[$val->id] = $val->name;
        }
        return $arr;
    }

    
    /**
     * @desc returns rule array (resource, privilege) acc. to given join Id.
     */
    public function getResourcePrivilegeFromJoin($id) {
        $res = dibi::dataSource('SELECT
                     r.name as resource,
                     p.name as privilege
                  FROM [' . self::TABLE_ACL_JOIN . '] j
                  LEFT JOIN [' . self::TABLE_RESOURCES . '] r on (r.id = j.resource_id)
                  LEFT JOIN [' . self::TABLE_PRIVILEGES . '] p on (p.id = j.privilege_id)
                  WHERE j.id = %i', $id, ' LIMIT 1');
        if ($res->count() == 0) {
            throw new NotFoundException();
        } else {
            return $res->fetch();
        }
    }

    
    /**
     * @desc adds privilege rule to join table
     */
    public function addRule($args) {
        dibi::insert(self::TABLE_ACL_JOIN, $args)->execute();
        return dibi::insertId();
    }

    
    /**
     * @desc updates rule
     */
    public function updateRule($args) {
        return dibi::update(self::TABLE_ACL_JOIN, $args)->where('id=%i', $args['id'])->execute();
    }

    
    public function deleteRule($id) {
        dibi::delete(self::TABLE_ACL)->where('lib_acl_join_id=%i', $id)->execute();
        return dibi::delete(self::TABLE_ACL_JOIN)->where('id=%i', $id)->execute();
    }

    /**
     * @desc returns join
     */
    public function getRules($groupId) {
        return dibi::select('*')
                ->from(self::TABLE_ACL_JOIN)
                ->where('group_id=%i', $groupId);
    }

    public function deleteGroup($groupId) {
        foreach ($this->getRules($groupId) as $rule) {
            $this->deleteRule($rule->id);
        }
        dibi::delete(self::TABLE_GROUPS)->where('id=%i', $groupId)->execute();
    }

    /**
     * @desc returns all groups
     */
    public function findGroup($value = null, $column = 'id', $context = 'i') {

        $res = dibi::select('*')
                        ->from(self::TABLE_GROUPS)
                        ->toDataSource();

        if ($value == null)
            return $res;

        $res = $res->where($column . '=%' . $context, $value);

        if ($res->count() == 0) {
            throw new NotFoundException();
        } elseif ($res->count() == 1) {
            return $res->fetch();
        } else {
            return $res;
        }
    }

    public function updateGroup($data) {
        dibi::update(self::TABLE_GROUPS, $data)->where('id=%i', $data['id'])->execute();
    }

    /**
     * @desc adds group
     */
    public function addGroup($data) {
        return dibi::insert(self::TABLE_GROUPS, array('id' => '', 'name' => $data['name']))
                ->execute();
    }

}