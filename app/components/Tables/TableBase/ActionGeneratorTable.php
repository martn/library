<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActionGeneratorTable
 *
 * @author martin
 */
require_once LIBS_DIR . '/MyLib/Action/IActionGenerator.php';
require_once 'TableBase.php';

abstract class ActionGeneratorTable extends TableBase implements IActionGenerator {

    private static $NAMESPACE = 'ACTIONS';
    private static $ARG_PROTOTYPE = 'argPrototype';
    private static $ARG_STATIC = 'argStatic';
    private static $ICON = 'icon';
    private static $ICONTITLE = 'icontitle';
    private static $AJAX = 'ajax';
    private static $CONFIRM = 'confirm';
    private static $ACTION = 'action';

    /**
     * returns true if there are some actions
     * @return unknown_type
     */
    function countActions() {
        return $this->countObjects(self::$NAMESPACE);
    }

    /**
     *
     * @param array $arg 
     */
    function addActionArgPrototype(array $arg) {
        foreach ($arg as $key => $value) {
            $this->getCurrent(self::$NAMESPACE)
                    ->offsetGet(self::$ARG_PROTOTYPE)
                    ->add($key, $value);
        }
        return $this;
    }

    function addActionArgStatic(array $staticArg) {
        foreach ($staticArg as $key => $value) {
            $this->getCurrent(self::$NAMESPACE)
                    ->offsetGet(self::$ARG_STATIC)
                    ->add($key, $value);
        }
        return $this;
    }

    function setAjax($ajax = true) {
        $this->getCurrent(self::$NAMESPACE)
                ->offsetSet(self::$AJAX, $ajax);
        return $this;
    }

    function setIconName($name) {
        $this->getCurrent(self::$NAMESPACE)
                ->offsetSet(self::$ICON, $name);
        return $this;
    }

    function setIconTitle($name) {
        $this->getCurrent(self::$NAMESPACE)
                ->offsetSet(self::$ICONTITLE, $name);
        return $this;
    }

    function setConfirmMessage($confirmMessage = NULL) {
        $this->getCurrent(self::$NAMESPACE)
                ->offsetSet(self::$CONFIRM, $confirmMessage);
        return $this;
    }

    /**
     * 
     * @param IWebAction $action
     * @return ActionGeneratorTable 
     */
    function addActionPrototype(IWebAction $action) {

        if($action->getContainer() == NULL) $action->setContainer($this->getParent());

        $this->addObject(new Hashtable(array(self::$ACTION => $action,
                    self::$ARG_PROTOTYPE => new Hashtable(),
                    self::$ARG_STATIC => new Hashtable(),
                    self::$AJAX => false,
                    self::$ICON => NULL,
                    self::$CONFIRM => NULL)),
                self::$NAMESPACE);

        return $this;
    }

    /**
     * returns action menu for given data
     * @param Traversable $data
     * @return unknown_type
     */
    protected function getActionMenu($data) {
        $menu = $this->getComponent('actionsMenu');
        $menu->reset();

        foreach ($this->getObjects(self::$NAMESPACE) as $def) {

            $aP = array();
            foreach ($def->offsetGet(self::$ARG_PROTOTYPE)->getArrayCopy() as $key => $value) {
                $aP[$key] = $data->$value;
            }

            $action = $def->offsetGet(self::$ACTION)->getClone();

            $action->addArgs($def->offsetGet(self::$ARG_STATIC)->getArrayCopy());
            $action->addArgs($aP);


            $menu->addActionElement($action, $def[self::$ICON]);

            if (isset($def[self::$ICONTITLE]))
                $menu->setIconTitle($def[self::$ICONTITLE]);

            $menu->setAjax($def[self::$AJAX]);

            if ($def[self::$CONFIRM])
                $menu->setConfirm($def[self::$CONFIRM]);
        }

        return $menu;
    }

    protected function createComponent($name) {
        switch ($name) {
            case "actionsMenu":
                $menu = new QuickActionsMenu($this, $name);
                $menu->setSizeSmall();
                return;
            default:
                parent::createComponent($name);
                return;
        }
    }

}