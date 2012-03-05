<?php

require_once dirname(__FILE__) . '/Base/MapsBasePresenter.php';

final class Front_MenusPresenter extends Front_MapsBasePresenter {

    public function startup() {
        parent::startup();

        $this->model = $this->modelMenus;
        $this->modelMItems = $this->modelMenuItems;

        if (!empty($this->id))
            $this->modelMItems->setMapId($this->id);
    }

    /**
     * @desc returns some text
     * @param unknown_type $item
     * @return string
     */
    protected function getText($item) {
        switch ($item) {
            case self::TEXT_NEWITEM:
                return 'vytvořit nové menu';
            case self::TEXT_CONFIRMDELETEITEM:
                return 'Opravdu chcete smazat menu ';
            default:
                return "";
        }
    }

}

