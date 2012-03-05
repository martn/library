<?php

//require_once LIBS_DIR.'/dibi/dibi.php';
require_once LIBS_DIR . '/Nette/Utils/Object.php';
require_once dirname(__FILE__) . '/IAction.php';

/**
 * @author martin
 *
 */
class Action extends NObject implements IAction {

    /**
     * @var string
     */
    protected $name;
    /**
     * @var IModel
     */
    protected $model;
    /**
     * @var array
     */
    private $args;

    /**
     * @param IActionContainer $component
     * @param string $link
     * @param mixed $args
     * @return unknown_type
     */
    public function __construct($name, // action name - refers to model action and component signal/action
            IActionModel $model, // model - related IModel object
            array $args = array()) { // arguments - single argument or array
        
        $this->args = new Hashtable();

        $this->setModel($model);
        $this->setName(trim($name));

        $this->addArgs($args);
    }



    
    function  getClone() {
        return new self($this->name, $this->model, $this->getArgs());
    }


    /**
     *
     */
    function getModel() {
        return $this->model;
    }

    /**
     * @param IModel $model
     */
    function setModel(IActionModel $model) {
        $this->model = $model;
    }

    function execute() {
        return $this->model->action($this);
    }

    /**
     * adds arguments
     * @param mixed $args
     * @return self
     */
    function addArgs(array $args) {

        foreach ($args as $key => $value) {
            if ($this->args->offsetExists($key)) {
                throw new ActionArgumentOffsetExist();
            } else {
                $this->args->add($key, $value);
            }
        }
        return $this;
    }

    /**
     * returns true if action is possible
     * @return boolean
     */
    function isPossible() {
        return $this->getModel()->isActionPossible($this);
    }

    /**
     * returns action name
     * @return string
     */
    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }



    function getArgument($key) {
        return $this->args->get($key, NULL);
    }

    /**
     * returns action arguments
     * @return array
     */
    function getArgs() {
        return $this->args->getArrayCopy();
        /*
        if ($this->args->count() == 1) {
            $keys = $this->args->getKeys();
            return $this->args->get($keys[0]);
        } else {
            return $this->args->getArrayCopy();
        }*/
    }

}

class ActionNotPossibleException extends Exception {

}

class ActionArgumentOffsetExist extends Exception {
    
}
