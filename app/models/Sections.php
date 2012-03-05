<?php

require_once dirname(__FILE__) . '/DataStructures/Tree/TreeModel.php';

class Sections extends TreeModel {
    const RESTRICTION_NONE = 'none';
    const RESTRICTION_RULE = 'rule';
    const RESTRICTION_PARENT = 'parent';


    private $modelPrivileges;

    /**
     * @desc constructor
     */
    public function __construct() {
        $this->modelPrivileges = new PrivilegesModel();

        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_SECTIONS;
    }


    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Tree/TreeModel#getChilds($parent_id)
     */
    public function getChilds($id = NULL) {

        $ret = new ArrayList();
        foreach (parent::getChilds($id) as $child) {
            if ($this->userAdmitted($child->id))
                $ret->append($child);
        }
        return $ret;
    }

    
    /**
     * @desc returns true if user is allowed to view a section
     */
    public function userAdmitted($id) {
        if (NEnvironment::getUser()->isInRole('superadmin'))
            return true;

        try {
            $joinId = $this->ruleFromSectionId($id);

            $restriction = $this->modelPrivileges->getResourcePrivilegeFromJoin($joinId);

            return NEnvironment::getUser()->isAllowed($restriction->resource, $restriction->privilege);
        } catch (NotFoundException $e) {
            return true;
        } catch (NoRuleException $e) {
            return true;
        }
    }



    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Tree/TreeModel#delete($id, $table)
     */
    public function delete($id, $table = null) {
        $mapsitems = new MapsItems();
        foreach ($mapsitems->dataSource($id, 'section_id') as $mapItem) {
            $mapsitems->delete($mapItem->id);
        }

        parent::delete($id);
    }

    /**
     * @desc remove possible privilege - item_id -> id in section_privilege table
     */
    public function removePossiblePrivilege($args) {
        dibi::delete(self::TABLE_SECTIONS_PRIVILEGES)
                ->where('id=%i', $args['item_id'])
                ->execute();
    }


    function isActionPossible(IAction $action) {

        $name = $action->getName();
        $args = $action->getArgs();

        switch ($name) {
            case 'edit':
            case 'view':
            default:
                break;
        }
        return $this->userAllowed('sections', 'edit');
    }

    /**
     * @desc returns defined section id from presenter object
     */
    public function sectionIdFromPresenter(NPresenter $presenter) {
        $ar = explode(":", strtolower($presenter->getAction(true)));
        $link = $ar[2] . ":" . $ar[3];

        $res = dibi::select('id')->from(self::TABLE_SECTIONS)->where('link=%s', $link)->toDataSource();

        if ($res->count() > 0) {
            return $res->fetch()->id;
        } else {
            throw new NotFoundException();
        }
    }

    /**
     * @desc returns rule id according to given section Id
     */
    public function ruleFromSectionId($id) {
        try {
            $section = $this->find($id);

            switch ($section->restriction) {
                case self::RESTRICTION_PARENT:

                    try {
                        return $this->ruleFromSectionId($section->parent_id);
                    } catch (NoRuleException $e) {
                        throw $e;
                    }

                case self::RESTRICTION_RULE:
                    return $section->lib_acl_join_id;

                case self::RESTRICTION_NONE:
                default:
                    throw new NoRuleException();
            }
        } catch (NotFoundException $e) {
            throw new NoRuleException();
        }
    }

    /**
     * @desc returns all possible permissions according to given id
     */
    /* 	public function getPossiblePrivileges($id) {

      $res = $this->getPossiblePrivilegesData($id);

      foreach($res as $r) {
      $r->offsetSet('fromParent', false);
      }

      return $this->recursiveGetParentPossiblePrivileges($id, $res);
      } */



    /**
     * @desc returns possible privileges acc to id
     */
    /*  private function getPossiblePrivilegesData($id)
      {
      return dibi::query('SELECT
      p.name AS name,
      p.id AS privilege_id,
      s_p.id AS id
      FROM ['.self::TABLE.'] s
      JOIN ['.self::TABLE_SECTIONS_PRIVILEGES.'] s_p ON (s.id = s_p.section_id)
      LEFT JOIN ['.self::TABLE_PRIVILEGES.'] p ON (p.id = s_p.privilege_id)
      WHERE s.id=%i', $id)->fetchAll();
      } */



    /**
     * @desc recursive body of get possible privileges - iterates through parents
     */
    /*   private function recursiveGetParentPossiblePrivileges($id, array $res)
      {
      try {
      $parent = $this->getParent($id)->id;

      $r = $this->getPossiblePrivilegesData($parent);

      foreach($r as $item) {

      //$item = $item->getArrayCopy();
      $defined_by_child = false;

      foreach($res as $pp) {
      if($item->privilege_id == $pp->privilege_id) {
      $pp->offsetSet('fromParent', true);

      $defined_by_child = true;
      }
      }

      if(!$defined_by_child) {
      $item->offsetSet('fromParent', true);
      array_push($res, $item);
      }
      }

      return $this->recursiveGetParentPossiblePrivileges($parent, $res);
      } catch(NotFoundException $e) {

      return $res;
      }
      } */



    /**
     * @desc adds possible privilege to section
     */
    /*  public function addPossiblePrivilege($args)
      {
      settype($args['section_id'], "integer");

      if($this->exists($args['section_id'])) {
      if(!isset($args['id'])) $args['id'] = '';
      $count = dibi::select('id')
      ->from(self::TABLE_SECTIONS_PRIVILEGES)
      ->where('section_id=%i',$args['section_id'])
      ->where('privilege_id=%i',$args['privilege_id'])
      ->count();
      if($count == 0) {
      dibi::insert(self::TABLE_SECTIONS_PRIVILEGES, $args)->execute();
      }
      }
      //return dibi::insertId();
      } */



    
    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#insert($args, $table)
     */
    public function insert(array $args, $table = null) {
        list($args['link'], $args['item']) = $this->transformLink($args['link']);
        return parent::insert($args, $table);
    }



    
    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#update($args, $table)
     */
    public function update(array $args, $table=null) {
        list($args['link'], $args['item']) = $this->transformLink($args['link']);
        return parent::update($args, $table);
    }


    /**
     * @desc returns "nice looking" link from data
     */
    public function niceLink($data) {
        $ret = str_replace(':', '/', $data['link']);

        if (substr_count($ret, '/') > 0) {
            if ($data['item'] != '') {
                $ret .= '/' . $data['item'];
            }
        }
        return $ret;
    }

    /**
     * @desc permforms link transformation
     */
    private function transformLink($link) {
        if ($link[0] == '/')
            $link = substr($link, 1);

        $link = NString::lower($link);

        $arr = explode('/', $link);

        if (count($arr) > 0) {
            // link is not empty

            if (count($arr) == 1) {
                // link is just presenter
                $ret = array($arr[0] . ':default', '');
            }

            if (count($arr) == 2) {
                // link is presenter/action
                $ret = array($arr[0] . ':' . $arr[1], '');
            }

            if (count($arr) > 2) {
                // link is presenter/action/item
                $ret = array($arr[0] . ':' . $arr[1], $arr[2]);
            }
        }
        return $ret;
    }

}

class NoRuleException extends Exception {

}