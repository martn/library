<?php

/**
 * MyLib
 *
 * @copyright  Copyright (c) 2010 Martin Novák
 * @link       http://nettephp.com
 * @category   MyLib
 * @package    MyLib
 */
/**
 * Standard Model class, that provides standard functionality such as insert, delete, etc. including form generating
 *
 * @copyright  Copyright (c) 2010, Martin Novák
 * @package    MyLib
 *
 * @property 	static DibiConnection $conn
 */
//require_once LIBS_DIR.'/dibi/dibi.php';

require_once dirname(__FILE__) . '/IModel.php';
require_once dirname(__FILE__) . '/ActionModel.php';

abstract class StandardModel extends ActionModel implements IModel {
    
    const FORM_CONTROL_TEXT = 'text';
    const FORM_CONTROL_SELECT = 'select';
    const FORM_CONTROL_TEXTAREA = 'textarea';
    const FORM_CONTROL_CHECKBOX = 'checkbox';
    const FORM_CONTROL_HIDDEN = 'hidden';
    const FORM_CONTROL_MFILEUPLOAD = 'multiplefileupload';
    const FORM_CONTROL_DATE = 'date';
    const FORM_GROUP = 'group';


    const FORM_DEFAULT_TEXT_SIZE = 28;
    const FORM_DEFAULT_TEXT_MAXLENGTH = 200;
    const FORM_DEFAULT_TEXTAREA_COLS = 30;
    const FORM_DEFAULT_TEXTAREA_ROWS = 3;


    const DEFAULT_FORM_HANDLER = 'standardSaveForm';


    protected $id;
    /** @var DibiConnection */
    protected static $conn;

    /**
     * @desc returns basic table for fundamental operations
     * @return string
     */
    abstract function getTable();

    /**
     * sets id of the model
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    /**
     * @desc constructor
     */
    public function __construct() {
        if (!dibi::isConnected())
            self::connect();
    }

    /** @var lang */
    protected static $lang = 'cs';

    /**
     * @desc sets the language
     */
    public static function setLang($lang) {
        self::$lang = $lang;
    }

    /**
     * @desc returns language
     */
    public function getLang() {
        return self::$lang;
    }

    /**
     * @desc connects to the database
     */
    public function connect() {
        self::$conn = dibi::connect(NEnvironment::getConfig('database')->toArray());
    }

    /**
     * returns true if current user is allowed to...
     * @param $resource
     * @param $privilege
     * @return boolean
     */
    function userAllowed($resource = NULL, $privilege = NULL) {
        return Utils::userAllowed($resource, $privilege);
    }


    
    public function processInsert(array $args) {
        return $this->insert($args);
    }

    public function processUpdate(array $args) {
        return $this->update($args);
    }

    public function processDelete(array $args) {
        return $this->delete($args['id']);
    }


    
    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#insert($args)
     */
    public function insert(array $args, $table = NULL) {

        // postgre auto_increment column insert fix
        if (isset($args['id']))
            unset($args['id']);

        // TODO: get types from the database
        foreach ($args as $key => $val)
            if (is_numeric($val))
                settype($args[$key], 'integer');

        dibi::insert($table === NULL ? $this->getTable() : $table,
                $args)->execute();

        return dibi::insertId();
    }

    /**
     * returns Form object
     * @return Form
     */
/*    protected function newFormObject() {
        return new MyForm();
    }*/

    /**
     * creates new Form from given definition.
     * @param array $definition
     * @param integer $id
     * @return MyForm
     */
 /*   protected function createForm(array $definition, $id = NULL) {
        $form = $this->addFormControlsGroup($this->newFormObject(), $definition);

        //$form->setHandle(self::DEFAULT_FORM_HANDLER);
        // id check
        if (!isset($form['id']))
            $form->addHidden('id');

        if (!empty($id)) {
            try {
                $form->setDefaults($this->find($id));
            } catch (NotFoundException $e) {

            }
        }

        $form->setCurrentGroup();

        return $form;
    }*/

    /**
     * adds group of control according to given definition see getFormDefinition
     * @param Form $form
     * @param array $controlsDefinition
     * @return MyForm
     */
/*    private function addFormControlsGroup(MyForm $form, array $controlsDefinition) {
        foreach ($controlsDefinition as $item) {
            if (!is_array($item))
                throw new InvalidFormDefinitionException();

            if ($item[0] == 'group') {
                $form->addGroup($item[1]);
                $this->addFormControlsGroup($form, array_slice($item, 2));
            } else {

                $this->addFormControl($form, $item);
            }
        }

        return $form;
    }
*/
    /**
     * adds control to the form
     * @param Form $form
     * @param unknown_type $def
     * @return unknown_type
     */
/*    private function addFormControl(MyForm $form, array $def) {
        list($type, $name, $label) = $def;

        $args = array_slice($def, 4);

        switch ($type) {
            case 'text':

                $control = $form->addText($name,
                                $label,
                                isset($args[0]) ? $args[0] : self::FORM_DEFAULT_TEXT_SIZE,
                                isset($args[0]) ? $args[0] : self::FORM_DEFAULT_TEXT_MAXLENGTH);
                break;
            case 'textarea':

                $control = $form->addTextArea($name,
                                $label,
                                isset($args[0]) ? $args[0] : self::FORM_DEFAULT_TEXTAREA_COLS,
                                isset($args[0]) ? $args[0] : self::FORM_DEFAULT_TEXTAREA_ROWS);
                break;
            case 'hidden':

                $control = $form->addHidden($name,
                                $label);
                break;
            case 'select':

                $control = $form->addSelect($name,
                                $label,
                                isset($args[0]) ? $args[0] : array());
                break;
            case 'checkbox':

                $control = $form->addCheckbox($name,
                                $label);
                break;
            default:
                throw new InvalidFormDefinitionException();
                break;
        }

        if (!empty($def[3]))
            $form->addQuickHelp($control, $def[3]);

        return $control;
    }*/

    /**
     * saves data from form (inserts or updates)
     * @param MyForm $form
     * @return unknown_type
     */
    /* 	public function saveForm(MyForm $form)
      {
      $handle = $form->getHandle();

      return $this->$handle($form);
      } */




    /**
     * standard method for saving form data
     * @param MyForm $form
     * @return unknown_type
     */
    /* 	protected function standardSaveForm(MyForm $form)
      {
      return $this->saveFormData($form->getValues());
      } */




    /**
     * saves data from form
     * @param array $data
     * @return unknown_type
     */
    /* 	protected function saveForm(MyForm $form, $table = NULL)
      {
      $data = $form->getValues();
      if(empty($data['id']))
      {
      return $this->insert($data, $table);
      } else {
      return $this->update($data, $table);
      }
      } */

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#exists($value, $col, $context, $table)
     */
    public function exists($value, $col = 'id', $context = 'i', $table = NULL) {
        $res = dibi::select('*')
                        ->from($table === NULL ? $this->getTable() : $table)
                        ->where($col . '=%' . $context, $value);

        return $res->count() > 0 ? true : false;
    }

    /**
     * @desc retrieve specific record (all with
     */
    public function find($value = NULL, $column = 'id', $context = 'i', $table = NULL) {
        $res = $this->dataSource($value, $column, $context, $table);

        if ($res->count() == 0) {
            throw new NotFoundException();
        } elseif ($res->count() == 1) {
            return $res->fetch();
        } else {
            return $res;
        }
    }


    
    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#dataSource($value, $column, $context, $table)
     */
    public function dataSource($value = NULL, $column = 'id', $context = 'i', $table = NULL) {

        $res = dibi::select('*')->from($table === NULL ? $this->getTable() : $table)->toDataSource();

        if ($value !== NULL) {
            $res = $res->where($column . '=%' . $context, $value);
        } elseif($context === NULL) {
            $res = $res->where($column.' IS NULL ');
        }

        return $res;
    }

    
    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#delete($id)
     */
    public function delete($id, $table = NULL) {
        return dibi::delete($table === NULL ? $this->getTable() : $table)
                ->where('id=%i', $id)
                ->execute();
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#update($args, $table)
     */
    public function update(array $args, $table = NULL) {
        $id = $args['id'];
        unset($args['id']);

        //throw new Exception("prdel".$id);
        return dibi::update($table === NULL ? $this->getTable() : $table,
                        $args)
                ->where('id=%i', $id)
                ->execute();
    }

}

class InvalidActionException extends Exception {

}

class BadFormatException extends Exception {

}

class InvalidFormDefinitionException extends Exception {

}

class NotFoundException extends DibiException {

}

