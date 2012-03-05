<?php

require_once dirname(__FILE__) . '/Base/BaseModel.php';

/**
 * Users authenticator.
 */
class UsersModel extends BaseModel {

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_USERS;
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#getForm($id)
     */
    /* 	function getForm($id = NULL)
      {

      $definition = array(
      array('group', 'základní údaje',
      array('text', 'name', 'jméno'),
      array('text', 'surname', 'příjmení'),
      array('text', 'username_changethis', 'uživatelské jméno'),
      ),

      array('group', 'heslo',

      array('text', 'passw', 'heslo'),
      array('text', 'passw2', 'potvrzení hesla')
      ),

      array('group', 'kontakt',
      array('text', 'mail', 'e-mail'),
      array('text', 'tel', 'telefon'),
      array('text', 'web', 'webová stránka'),
      array('textarea', 'adress', 'adresa', '')
      )
      );

      $form = $this->createForm($definition, $id);

      $form['name']->addRule(Form::FILLED,'jméno je povinné');

      $form['surname']->addRule(Form::FILLED,'příjmení je povinné');

      $form['username_changethis']->addRule(Form::FILLED,'uživatelské jméno je povinné')
      ->addRule(array($this,'usernameUnique'),'Uživatelské jméno již existuje, prosím zvolte jiné.');

      $form['passw']->addRule(Form::FILLED,'zadejte heslo');

      $form['passw2']->addRule(Form::FILLED,'zadejte potvrzení hesla')
      ->addConditionOn($form['passw'], Form::VALID)
      ->addRule(Form::EQUAL, 'Hesla se neshodují.', $form['passw']);

      $form['mail']->setEmptyValue('@')
      ->addCondition(Form::FILLED) // conditional rule: if is email filled, ...
      ->addRule(Form::EMAIL, 'e-mail není platný'); // ... then check email

      $form->setHandle($this, empty($id) ? 'insert' : 'update');

      return $form;
      } */

    /**
     * @desc returns username according to given id
     */
    public function getUsernameById($id) {
        return dibi::select('username')
                ->from($this->getTable())
                ->where('id=%i', $id)
                ->fetchSingle();
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#delete($id, $table)
     */
    public function delete($id, $table = null) {

        dibi::delete(self::TABLE_USERS_ROLES)
                ->where('user_id=%i', $id)
                ->execute();

        parent::delete($id);
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#isActionPossible($action)
     */
    function isActionPossible(IAction $action) {
        $name = $action->getName();
        $args = $action->getArgs();

        switch ($name) {
            case 'view':
                return $this->userAllowed('users', 'view');
            case 'delete':
                if (NEnvironment::getUser()->getIdentity()->data['id'] == $args['id'])
                    return false;
            case 'edit':
            case 'newroles':
            case 'password':
            case 'detail':
                if (!$this->exists($args['id']))
                    return false;
                if($name === "edit" & $args['id'] === NEnvironment::getUser()->getIdentity()->data['id']) {
                    return true;
                }
                break;
            case 'removeUserFromRole':
                if (!$this->exists($args['id']) | !$this->isUserInRole($args['id'], $args['roleId']))
                    return false;
            default:
                break;
        }

        return $this->userAllowed('users', 'edit');
    }


    
    /**
     * @desc creates new Identity object
     * @param $username
     * @return IIdentity object
     */
    public function getIdentity($username) {
        try {
            $userdata = $this->find($username, 'username', 's');

            return new NIdentity($userdata->name . " " . $userdata->surname,
                    $this->getRolesAbbrs($userdata->id),
                    $userdata);
        } catch (NotFoundException $e) {
            throw new NotFoundException();
        }
    }

    /**
     * @desc returns all users from defined role
     */
    public function getUsersInRole($role_id) {
        return dibi::dataSource('SELECT u.* 
                            FROM [' . self::TABLE_USERS . '] u
                            LEFT JOIN [' . self::TABLE_USERS_ROLES . '] u_r
                            ON u.id = u_r.user_id
                            WHERE u_r.role_id=%i', $role_id);
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#insert($args, $table)
     */
    public function insert(array $args, $table = null) {
        $args['passw'] = $this->encrypt($args['psw']);

        $args['username'] = $args['usernm'];

        unset($args['usernm']);
        unset($args['psw2']);
        unset($args['psw']);

        return parent::insert($args);
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#update($args, $table)
     */
    public function update(array $args, $table = null) {
        if (isset($args['psw'])) {

            $args['passw'] = $this->encrypt($args['psw']);
            unset($args['psw2']);
            unset($args['psw']);
        }

        if (isset($args['usernm'])) {
            $args['username'] = $args['usernm'];
            unset($args['usernm']);
        }

        return parent::update($args);
    }

    /**
     * @desc adds user to role $args contain $user_id and $role_id
     */
    public function processAddUserToRole($args) {
        if ($this->exists($args['user_id'])) {
            if (!$this->isUserInRole($args['user_id'], $args['role_id'])) {
                dibi::insert(self::TABLE_USERS_ROLES, $args)->execute();
            }
        }
    }

    /**
     * returns 0 if user not in role, > 0 otherwise.
     * @param unknown_type $userId
     * @param unknown_type $roleId
     */
    function isUserInRole($userId, $roleId) {
        return dibi::select('id')
                ->from(self::TABLE_USERS_ROLES)
                ->where('user_id=%i', $userId)
                ->where('role_id=%i', $roleId)
                ->count();
    }


    function getSelectBoxArray() {
        $ret = array();
        foreach($this->dataSource()->orderBy('surname') as $user) {
            $ret[$user->id] = $user->surname." ".$user->name;
        }
        return Utils::addEmptyRowToArray($ret);
    }
    
    /**
     * @desc removes user from role
     */
    public function processRemoveUserFromRole($args) {

        return dibi::delete(self::TABLE_USERS_ROLES)
                ->where('user_id=%i', $args['id'])
                ->where('role_id=%i', $args['roleId'])
                ->execute();
    }

    /**
     * @desc updates identity according to given id or authorized user.
     */
    public function updateIdentity($id = 0) {
        if ($id == 0) {
            $id = NEnvironment::getUser()->getIdentity()->id;
        }
        $user = $this->find($id);
        //Environment::getUser()->authenticate($user[')
    }

    /**
     * @desc checks if given username exists
     */
    public function userExists($item) {
        return dibi::select('username')
                ->from($this->getTable())
                ->where('username=%s', strtolower($item))
                ->count();
    }

    /**
     * @desc password encryption
     */
    public function encrypt($text) {
        return md5(hash('sha256', $text));
    }

    /**
     * @desc returns roles abbr array acc. to given id
     */
    public function getRolesAbbrs($id) {
        $arr = array();
        foreach ($this->getRoles($id) as $value) {
            array_push($arr, $value->abbr);
        }
        return $arr;
    }

    /**
     * @desc returns roles array acc. to given id
     */
    public function getRolesArray($id) {
        $arr = array();
        foreach ($this->getRoles($id) as $value) {
            array_push($arr, $value->name);
        }
        return $arr;
    }

    /**
     * @desc returns all roles according to given id
     */
    public function getRoles($id) {
        return dibi::query('SELECT 
                                r.name AS name ,
                                r.abbr AS abbr,
                                r.id AS id
                                FROM [' . $this->getTable() . '] u
                                JOIN [' . self::TABLE_USERS_ROLES . '] u_r ON (u.id = u_r.user_id)
                                LEFT JOIN [' . self::TABLE_ROLES . '] r ON (r.id = u_r.role_id)
                                WHERE u.id=%i', $id);
    }

    /**
     * TODO: prekopat getRolesTree...
     * @desc returns all roles tree according to given user id
     */
    public function getRolesTree($id) {
        $rm = new Roles();
        $tree = clone $rm->getTree();

        $roles = $this->getRoles($id);

        $this->keepBranch_getRolesTree($tree, $roles);

        return $tree;
    }

    /**
     * @desc recursive body of getRolesTree
     */
    private function keepBranch_getRolesTree(Tree $tree, $roles) {
        $retval = false;

        if ($tree->countChilds() > 0) {
            foreach ($tree->getChilds() as $key => $branch) {

                if (!$this->keepBranch_getRolesTree($branch, $roles)) {
                    $tree->removeChild($branch);
                } else {
                    $retval = true;
                }
            }
        }

        foreach ($roles as $role) {
            if ($role->id == $tree->id) {
                return true;
            }
        }

        return $retval;
    }

}
