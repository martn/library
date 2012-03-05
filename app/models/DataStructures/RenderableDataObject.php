<?php

/**
 * class implementing IRenderableDataList, to be used for rendering list data
 */
require_once dirname(__FILE__) . '/IRenderableDataObject.php';
require_once LIBS_DIR . '/Nette/Utils/Object.php';

/**
 * @author martin
 *
 */
abstract class RenderableDataObject extends NObject implements IRenderableDataObject {

    protected $renderer;

    
    /* (non-PHPdoc)
     * @see scripts/app/models/DataStructures/IRenderableDataList#setRenderer($renderer)
     */
    function setRenderer(IDataRenderer $renderer) {
        $this->renderer = $renderer;
    }

    /* (non-PHPdoc)
     * @see scripts/app/models/DataStructures/IRenderableDataList#getRenderer()
     */

    function getRenderer() {
        return $this->renderer;
    }
}