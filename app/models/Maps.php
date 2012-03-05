<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once dirname(__FILE__) . '/Base/BaseModel.php';

/**
 * Description of Menus
 *
 * @author martin
 */
class Maps extends BaseModel {

    protected $type;

    const TYPE_MAP = 'map';
    const TYPE_MENU = 'menu';


    public function __construct($type) {
        parent::__construct();

        $this->type = $type;
    }


    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_MAPS;
    }


    /**
     * @desc returns map id acc to given identificator
     */
    public function getIdFromIdentificator($identificator) {
        return $this->find($identificator, 'identificator', 's')->id;
    }



    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#dataSource($value, $column, $context, $table)
     */
    public function dataSource($value = NULL, $column = 'id', $context = 'i', $table = NULL) {
        return parent::dataSource($value, $column, $context, $table)->where('type=%s',  $this->type);
    }


    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#insert($args)
     */
    public function insert(array $args, $table = NULL) {
        if(!isset($args['type'])) $args['type'] = $this->type;
        return parent::insert($args, $table);
    }


    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#isActionPossible($action)
     */
    function isActionPossible(IAction $action) {
        //return false;
        //   print_r($action->getArgs());

        $name = $action->getName();
        $args = $action->getArgs();

        switch ($name) {
            case 'edit':
            case 'delete':
                if (!$this->exists($args['id']))
                    return false;
                break;
            default:
                break;
        }

        return $this->userAllowed('maps', 'edit');
    }
    
}

