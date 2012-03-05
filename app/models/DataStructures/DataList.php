<?php

/**
 * class implementing IRenderableDataList, to be used for rendering list data
 */
require_once dirname(__FILE__) . '/RenderableDataObject.php';

/**
 * @author martin
 *
 */
class DataList extends RenderableDataObject implements IRenderableDataObject {

    protected $ds;
    
    function __construct(DibiDataSource $ds) {
        $this->ds = $ds;
    }

    
    /* (non-PHPdoc)
     * @see scripts/app/models/DataStructures/IRenderableDataStructure#render($renderer)
     */
    function render(IDataRenderer $renderer = NULL) {
        if ($renderer !== NULL)
            $this->setRenderer($renderer);

        foreach ($this->ds as $item) {
            $this->getRenderer()->renderItem($item);
        }
    }

}