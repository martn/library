<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * class implementing IRenderableDataList, to be used for rendering list data
 */
require_once dirname(__FILE__) . '/RenderableDataObject.php';
/**
 * @author martin
 *
 */
class GroupDataList extends RenderableDataObject {
    
    private $groups;

    function  __construct() {
        $this->groups = new ArrayList();
    }

    
    function addGroup(DibiDataSource $dataSource, $data) {
        $this->groups->append(new GroupData($data, $dataSource));
    }


    function render(IDataRenderer $renderer = NULL) {
        if ($renderer !== NULL)
            $this->setRenderer($renderer);

        foreach($this->groups as $group) {
            $renderer->renderGroup($group);
        }
    }
}
