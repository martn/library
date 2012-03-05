<?php

/**
 * interface IDataRenderer - to be used for rendering list data
 * @author martin
 *
 */
interface IDataListRenderer extends IDataRenderer {
    function renderItem($data);
}