<?php

require_once dirname(__FILE__) . '/../DataViewBase/DataViewBase.php';

class DataTableView extends DataViewBase {

    function getLayout() {
        return dirname(__FILE__) . '/template.phtml';
    }

}

