<?php

interface IRenderableDataObject {

    /**
     * renders content with given renderer (or previously set renderer)
     * @param IDataRenderer $renderer
     * @return unknown_type
     */
    function render(IDataRenderer $renderer = NULL);

    /**
     * sets renderer
     * @param IDataRenderer $renderer
     * @return unknown_type
     */
    function setRenderer(IDataRenderer $renderer);
}