<?php

require_once dirname(__FILE__) . '/../DataViewBase/DataViewBase.php';

class DataBoxesView extends DataViewBase {

    function getLayout() {
        return dirname(__FILE__) . '/template.phtml';
    }

}

