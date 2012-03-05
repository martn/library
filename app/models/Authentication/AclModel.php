<?php

require_once dirname(__FILE__) . '/../Base/BaseModel.php';

class AclModel extends BaseModel {
    const ACTION_EDIT = 'edit';
    const ACTION_VIEW = 'view';

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_ACL;
    }

    /**
     * @desc returns all roles as a tree, (through parent_id)
     */
    public function getRoles() {
        return dibi::fetchAll('SELECT r1.abbr, r2.abbr as parent_name, r1.abbr
                               FROM [' . self::TABLE_ROLES . '] r1
                               LEFT JOIN [' . self::TABLE_ROLES . '] r2 ON (r1.parent_id = r2.id)
                              ');
    }

    /**
     * @desc returns all resources
     */
    public function getResources() {
        return dibi::fetchAll('SELECT name FROM [' . self::TABLE_RESOURCES . '] ');
    }

    /**
     * @desc returns true if role is allowed to privilege
     */
    public function roleIsAllowed($roleId, $privilegeId) {
        if (dibi::select('*')->from(self::TABLE_ACL)
                        ->where('role_id=%i', $roleId)
                        ->where('lib_acl_join_id=%i', $privilegeId)->count() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * sets privilege to role
     * @param unknown_type $roleId
     * @param unknown_type $privilegeId
     * @param unknown_type $value
     */
    public function roleUpdatePrivilege($roleId, $privilegeId, $value) {
        if ($value) {
            if (!$this->roleIsAllowed($roleId, $privilegeId)) {
                dibi::insert(self::TABLE_ACL, array('role_id' => $roleId,
                    'lib_acl_join_id' => $privilegeId))->execute();
            }
        } else {
            if ($this->roleIsAllowed($roleId, $privilegeId)) {
                dibi::delete(self::TABLE_ACL)
                        ->where('role_id=%i', $roleId)
                        ->where('lib_acl_join_id=%i', $privilegeId)
                        ->execute();
            }
        }
    }

    /**
     * @desc adds permission
     */
    /*    public function addPrivilege($role_id, $section_id, $privilege_id)
      {
      if(!$this->isPrivileged($role_id, $section_id, $privilege_id)) {
      $args = array('id'=>'',
      'role_id'=>$role_id,
      'section_id'=>$section_id,
      'privilege_id'=>$privilege_id);

      dibi::insert(AclModel::TABLE_ACL, $args)->execute();
      return dibi::insertId();
      } else {
      return false;
      }
      } */




    /**
     * @desc removes privilege from role and section
     */
    /*    public function removePrivilege($role_id, $section_id, $privilege_id)
      {
      dibi::delete(self::TABLE_ACL)
      ->where('role_id=%i',$role_id)
      ->where('section_id=%i',$section_id)
      ->where('privilege_id=%i',$privilege_id)
      ->execute();
      } */

    /**
     * @desc returns rules according to resources, roles, users, privileges and ACLs
     */
    public function getRules() {
        return dibi::fetchAll('
            SELECT
                ro.abbr as role,
                re.name as resource,
                p.name as privilege
                FROM [' . self::TABLE_ACL . '] a
                JOIN [' . self::TABLE_ROLES . '] ro ON (a.role_id = ro.id)
                LEFT JOIN [' . self::TABLE_ACL_JOIN . '] jo ON (a.lib_acl_join_id = jo.id)
                LEFT JOIN [' . self::TABLE_RESOURCES . '] re ON (jo.resource_id = re.id)
                LEFT JOIN [' . self::TABLE_PRIVILEGES . '] p ON (jo.privilege_id = p.id)
                ORDER BY a.id ASC
        ');
    }

}