<?php

require_once dirname(__FILE__) . '/Sortable/SortableTreeModel.php';

class MapItems extends SortableTreeModel {
    const IDENTIFICATOR_MAP = 'map';
    const IDENTIFICATOR_MENU = 'menu';


    private $modelSections;
    private $modelMaps;

    /**
     * @desc constructor
     */
    public function __construct($type) {
        parent::__construct();

        $this->modelSections = new Sections();
        $this->modelMaps = new Maps($type);
    }

    
    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_MAPS_ITEMS;
    }


    
    // =========== ISortableModel =======================
    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Sortable/ISortableModel#getSortableDataSource($id)
     */
    public function getSortableDataSource($id) {
        try {
            $data = $this->getSortableRecord($id);

            return $this->getChilds($data['parent_id']);
        } catch (NotFoundException $e) {
            throw $e;
        }
    }

    
    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Sortable/ISortableModel#getSortableRecord($id)
     */
    public function getSortableRecord($id) {
        return $this->find($id);
    }


    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Sortable/ISortableModel#getSortableTable()
     */
    public function getSortableTable() {
        return $this->getTable();
    }


    
    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/IModel#dataSource($value, $column, $context, $table)
     */
    public function dataSource($value = NULL, $column = 'id', $context = 'i', $table = NULL) {

        $res = dibi::select('items.*, section.link as link')
                ->from(self::TABLE_MAPS_ITEMS)->as('items')
                ->join(self::TABLE_SECTIONS)->as('section')->on('section.id=items.section_id')
                ->where('items.map_id=%i', $this->modelMaps->getId())
                ->orderBy('items.ord')
                ->toDataSource();

        if ($value !== NULL) {
            $res = $res->where($column . '=%' . $context, $value);
        } elseif($context === NULL) {
            $res = $res->where($column.' IS NULL ');
        }

       // print_r($this);
        //print_r("-> ".$this->modelMaps->getId()." <- ".$res->__toString());

        return $res;
    }



    function processDeleteItem($args) {
        $this->delete($args['itemId']);
    }

    
    // ====================================================
    /**
     * @desc returns children records according to parent id
     */
    public function getChilds($id = NULL) {
        $ret = new ArrayList();
        foreach (parent::getChilds($id) as $child) {
            if ($this->modelSections->userAdmitted($child->section_id))
                $ret->append ($child);
        }
        return $ret;
    }


    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#isActionPossible($action)
     */
    function isActionPossible(IAction $action) {
        $name = $action->getName();
        $args = $action->getArgs();

        switch ($name) {
            case 'newItem':
                if (!empty ($args['parentId']) & !$this->exists($args['parentId']))
                    return false;
                break;
            case 'editItem':
                if (!$this->exists($args['itemId']))
                    return false;
                break;
            case 'deleteItem':
                if (!$this->exists($args['itemId']))
                    return false;
                break;
            default:
                break;
        }

        return $this->userAllowed('maps', 'edit');
    }


    

    function setMapId($id) {
        try {
            $this->modelMaps->setId($id);
        } catch(NotFoundException $e) {
            
        }
    }


    
    function setMapIdentificator($identificator) {
        try {
            $map = $this->modelMaps->find($identificator, 'identificator', 's');

            $this->setMapId($map->id);
        } catch(NotFoundException $e) {
            
        }
    }

    
  
    /**
     * @desc returns map chain acc to give presenter
     */
    public function getChainFromPresenter(NPresenter $presenter, $type) {
        try {
            $sId = $this->modelSections->sectionIdFromPresenter($presenter);

            $res = dibi::select('item.*')
                            ->from(self::TABLE_MAPS_ITEMS)->as('item')
                            ->join(self::TABLE_MAPS)->as('map')
                            ->on('item.map_id=map.id')
                            ->where('map.type=%s', $type)
                            ->where('item.section_id=%i', $sId);

            if ($res->count() > 0) {
                return $this->getChain($res->fetch()->id);
            } else {
                return null;
            }
        } catch (NotFoundException $e) {
            return null;
        }
    }

    
    /**
     * returns mapitems chain acc to given leaf id
     */
    protected function getChain($id, $root = NULL) {
        try {
            $current = $this->getItemData($id);

            $newRoot = new Tree();

            if ($root != NULL)
                $newRoot->appendChild($root);


            $newRoot->addMultipleData($current);

            $this->getChain($current->parent_id, $newRoot);

            if ($root == NULL)
                return $newRoot->getRoot();
        } catch (NotFoundException $e) {
            return null;
        }
    }


    
    /**
     * @desc returns map item extended data 
     */
    public function getItemData($id) {
        $res = dibi::select('item.*,
    				  section.link as link,
    				  map.name as map_name')
                        ->from(self::TABLE_MAPS_ITEMS)->as('item')
                        ->join(self::TABLE_MAPS)->as('map')->on('item.map_id=map.id')
                        ->join(self::TABLE_SECTIONS)->as('section')->on('item.section_id = section.id')
                        ->where('item.id = %i', $id);
        if ($res->count() > 0) {
            return $res->fetch();
        } else {
            throw new NotFoundException();
        }
    }
}