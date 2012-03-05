<?php

require_once dirname(__FILE__) . '/DataStructures/Tree/TreeModel.php';

class Roles extends TreeModel {

    protected $modelAcl;

    /**
     * @desc constructor
     */
    public function __construct() {
        $this->modelAcl = new AclModel();

        parent::__construct();
    }

    /**
     * @return DataModelTree
     */
    function getUserRoleTree() {
        return $this->removeAbbrsFromTree($this->getTree(), array('guest'));
    }

    /**
     * returns tree for parent role choose
     * @return DataModelTree
     */
    public function getParentRoleTree() {
        return $this->removeAbbrsFromTree($this->getTree(), array('guest', 'superadmin'));
    }

    /**
     * @param Tree $tree
     * @param array $abbrs
     * @return DataModelTree
     */
    private function removeAbbrsFromTree(DataTree $tree, array $abbrs) {
        $tree = clone $tree;
        foreach ($tree->getChilds() as $child) {
            if (in_array($child->abbr, $abbrs))
                $tree->removeChild($child);
        }
        return $tree;
    }

    
    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_ROLES;
    }



    
    /**
     * returns privileges form according to group id
     * @param integer $id
     * @return MyForm
     */
    function getPrivilegesForm($id) {
        $form = $this->newFormObject();

        $modelPrivileges = new PrivilegesModel();

        foreach ($modelPrivileges->getGroups() as $group) {
            $form->addGroup($group->id);

            foreach ($modelPrivileges->getRules($group->id) as $join) {

                if ($this->parentRoleIsAllowed($id, $join->id)) {
                    $rl = $form->addRadioList('fake' . $join->id, $join->name, array('Ano'))
                                    ->setDefaultValue(0);

                    $rl->setDisabled(true);
                } else {

                    $form->addRadioList('allowed' . $join->id, $join->name, array('Ne', 'Ano'))
                            ->setDefaultValue($this->modelAcl->roleIsAllowed($id, $join->id));
                }
            }
        }

        $form->setCurrentGroup(null);
        $form->addHidden('id')->setDefaultValue($id);

        $form->setHandle($this, 'privilegesUpdate');

        return $form;
    }


    /**
     * removes user from role
     * @param <type> $roleId
     * @param <type> $userId 
     */
    function removeUserFromRole($args) {
        return dibi::delete(self::TABLE_USERS_ROLES)->where('role_id=%i',$args['roleId'])
                                            ->where('user_id=%i', $args['userId'])
                                            ->execute();
    }



    function processRemoveUser($args) {
        return $this->removeUserFromRole($args['id'], $args['userId']);
    }




    function processPrivilegesUpdate($args) {
        foreach ($args as $key => $value) {
            if (substr($key, 0, 7) === "allowed") {
                $this->modelAcl->roleUpdatePrivilege($args['id'], substr($key, 7), $value);
            }
        }
    }

     
    
    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#isActionPossible($action)
     */
    function isActionPossible(IAction $action) {
  
        $name = $action->getName();
        $args = $action->getArgs();

        switch ($name) {
            case 'edit':
            case 'privileges':
            case 'delete':
            case 'view':
            case 'removeUser':
            case 'new':
                try {
                    $group = $this->find($args['id']);

                    $exists = true;
                } catch (NotFoundException $e) {
                    $exists = false;
                }

                if ($exists) {
                    if ($group->abbr == 'guest' & $name != 'privileges')
                        return false;
                    if ($group->abbr == 'superadmin' & $name != 'view')
                        return false;
                    if (($group->abbr == 'guest' | $group->abbr == 'superadmin') & ($name == 'new'))
                        return false;
                }
                if ($name === 'view')
                    $this->userAllowed('groups', 'view');

                break;
            default:
                break;
        }

        return $this->userAllowed('groups', 'edit');
    }

    
    
    /**
     * @desc returns true, if there is a role in a parent chain, which grants a privilege acc to given privilegeId
     * @param $roleId
     * @param $privilegeId
     * @return bool
     */
    public function parentRoleIsAllowed($roleId, $privilegeId) {
        try {
            $parent = $this->getParent($roleId);

            $result = $this->modelAcl->roleIsAllowed($parent->id, $privilegeId);

            if ($result === false) {

                return $this->parentRoleIsAllowed($parent->id, $privilegeId);
            } else {
                return $result;
            }
        } catch (NotFoundException $e) {
            return false;
        }
    }

    /**
     * @desc removes all privileges
     */
    private function recursiveRemovePrivileges($id) {
        foreach ($this->getChilds($id) as $child) {
            $this->recursiveRemovePrivileges($child->id);
        }

        dibi::delete(self::TABLE_USERS_ROLES)
                ->where('role_id=%i', $id)
                ->execute();

        dibi::delete(self::TABLE_ACL)
                ->where('role_id=%i', $id)
                ->execute();
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#insert($args, $table)
     */
    public function insert(array $args, $table = null) {
        $args['abbr'] = uniqid('role');
        parent::insert($args);
    }



   /**
     * @desc
     */
    /*    private function recursiveUpdatePrivileges($sections, $data)
      {
      $modelSections = new Sections();

      foreach($sections->getChilds() as $section) {

      foreach($modelSections->getPossiblePrivileges($section->id) as $pp) {

      //echo $this->getUniqueName($section->id, $pp->privilege_id)."\n";

      if($data[$this->getUniqueName($section->id, $pp->privilege_id)]) {
      // checkbox is checked

      $this->modelAcl->addPrivilege($data['id'], $section->id, $pp->privilege_id);

      } else {
      // checkbox is unchecked
      //echo $this->getUniqueName($section->id, $pp->privilege_id);
      $this->modelAcl->removePrivilege($data['id'], $section->id, $pp->privilege_id);
      }
      }

      if($section->countChilds() > 0)
      $this->recursiveUpdatePrivileges($section, $data);
      }
      } */




    /**
     * @desc returns true if any parent role grants given permission to given section
     */
    /* 	public function sectionGrantedFromParent($id, $section_id, $privilege_id)
      {
      //$sections = new Sections();

      while($id != 0) {
      $role = $this->find($id);


      if($this->isPrivileged($role->parent_id, $section_id, $privilege_id)) {
      return true;
      } else {
      $id = $role->parent_id;
      }
      }
      return false;
      } */
}