<?php

require_once dirname(__FILE__) . '/Base/BasePresenter.php';

class Front_AccountPresenter extends Front_UserBasedPresenter {

    function startup() {
        parent::startup();

        $this->id = $this->user->getIdentity()->data['id'];
    }

    function actionDefault() {
        $this->setView('detail');

        
    }

    public function actionLogout() {
        $this->user->logout(true);
        $this->redirect('Default:default');
    }

    protected function createComponent($name) {
        switch ($name) {
            case "detailActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addElement($this->link('edit', array('backlink' => $this->getAction(true))), 'edit', 'upravit');
            default:
                parent::createComponent($name);
        }
    }

}
