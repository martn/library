<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once dirname(__FILE__) . '/IActionModel.php';
require_once LIBS_DIR . '/Nette/Utils/Object.php';

/**
 * Description of ActionModel
 *
 * @author martin
 */
class ActionModel extends NObject implements IActionModel {
     /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#isActionPossible($action)
     */
    function isActionPossible(IAction $action) {
        return true;
    }


    /* (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#action($action)
     */
    function action(IAction $action) {
        if (!$this->isActionPossible($action))
            throw new ActionNotPossibleException();
        return $this->executeAction($action);
    }

    
    
    /**
     * executes given action, returns true if successful
     * @param $action
     * @return mixed
     * @throws InvalidActionException
     */
    protected function executeAction(IAction $action) {
        if ($action->getArgs() === NULL)
            throw new InvalidActionException();
        return $this->tryCall("process" . $action->getName(), array("args" => $action->getArgs()));
    }


    /**
     * Calls public method if exists.
     * @param  string
     * @param  array
     * @return bool  does method exist?
     */
    public function tryCall($method, $params) {
      
        if (!is_array($params))
            $params = array($params);
      
        $rc = $this->getReflection();
        if ($rc->hasMethod($method)) {
            $rm = $rc->getMethod($method);
            if (!$rm->isAbstract() && !$rm->isStatic()) {
                return $rm->invokeArgs($this, $params);
            }
        }
        throw new InvalidActionException();
    }
}