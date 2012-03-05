<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author martin
 */
interface IGroupDataListRenderer extends IDataRenderer {
    
    function renderGroup(GroupData $group);

    function getListRenderer();
}
