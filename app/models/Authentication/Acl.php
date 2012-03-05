<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kokot
 *
 * @author martin
 */
class Acl extends NPermission {
    //put your code here
    public function __construct() {
        //parent::__construct();

        $model = new AclModel();
        //$sections = new Sections();
        $privileges = new PrivilegesModel();
        $roles = new Roles();

        $this->recursiveRolesFill($roles->getTree());

        foreach($privileges->getResourcesArray() as $name)
        {
           $this->addResource($name);
        }

        foreach($model->getRules() as $rule)
        {
            $this->allow($rule->role, $rule->resource, $rule->privilege);
        }
    }



    /**
    * @desc recursive recources fill
    */
  /*  private function recursiveResourcesFill(Tree $node)
    {
        foreach($node->getChilds() as $child) {
            if($node->isRoot()) {
                $this->addResource($child->link);
            } else {
                $this->addResource($child->link, $node->link);
            }

            $this->recursiveResourcesFill($child);
        }
    }*/



    /**
    * @desc recursive roles fill
    */
    private function recursiveRolesFill(Tree $node)
    {
        foreach($node->getChilds() as $child) {
            if($node->isRoot()) {
                $this->addRole($child->abbr);
            } else {
                $this->addRole($child->abbr, $node->abbr);
            }

            $this->recursiveRolesFill($child);
        }
    }
}