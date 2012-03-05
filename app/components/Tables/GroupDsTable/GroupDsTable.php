<?php
/**
 * @package Nette-components
 */
require_once dirname(__FILE__) . '/../TableBase/StructureRendererTable/StructureRendererTable.php';
require_once dirname(__FILE__) . '/../IGroupDataListRenderer.php';

class GroupDsTable extends StructureRendererTable implements IGroupDataListRenderer {

    private $listRenderer;

    private $currentGroup;

    public function __construct(IComponentContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);

        $this->setHtmlClass('tableDsGroup');
        $this->setShowHead(false);

        $this->listRenderer = new DsTable($this, 'listRenderer');
        $this->listRenderer->setShowHead(false);
    }


    function getListRenderer() {
        return $this->listRenderer;
    }

    public function getCurrentGroup() {
        return $this->currentGroup;
    }

    public function setCurrentGroup($group) {
        $this->currentGroup = $group;
    }

    
    function renderGroup(GroupData $group) {
        $this->setCurrentGroup($group);

        $this->renderItem($group->getData());
    }


    function renderList() {
       // $this->getListRenderer()->reset();
        $this->getListRenderer()->setDataSource($this->getCurrentGroup()->getDataSource());
        $this->getListRenderer()->render();
    }


    protected function getRowTemplate() {
        return dirname(__FILE__) . '/row.phtml';
    }
}

