<?php

require_once dirname(__FILE__) . '/../TableBase/StructureRendererTable/StructureRendererTable.php';

class TreeTable extends StructureRendererTable {

    public function __construct(IComponentContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);

        $this->setHtmlClass('tableTree');
    }

    function renderCell($data, HashTable $col, NSmartCachingIterator $iterator) {
        $additional = '';
        if ($iterator->first & $data->getLevel() > 0) {
            $additional .= str_repeat("<div class=\"tableTreeFiller\">&nbsp;</div>", $data->getLevel()) . "<sup>|_</sup> &nbsp;";
        }
        return $additional . parent::renderCell($data, $col, $iterator);
    }

}

