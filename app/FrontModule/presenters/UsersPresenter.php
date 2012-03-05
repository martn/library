<?php

require_once dirname(__FILE__) . '/Base/UserBasedPresenter.php';

final class Front_UsersPresenter extends Front_UserBasedPresenter {
    const STAGE_NEWROLES = 10;


    function handleRemoveUserFromRole($token) {
        $this->signalHandle("Uživatel byl vyjmut z vybrané skupiny.");
    }

    public function renderShow($username) {
        $this->addTitle("Detail Uživatele");
    }

    public function renderDefault() {
        $this->addTitle("Seznam uživatelů");
    }

    public function renderEdit($id) {
        $this->addTitle("Upravit informace o uživateli");
    }

    /**
     * @desc action new user - stage 2
     */
    public function actionRoles($id) {
        $this->actionCheck(new WebAction('roles', $this->model, $this, array('id' => $id)));
    }


    
    /**
     * @desc new form handle
     */
    public function formNewSubmitted(NSubmitButton $button) {
        $this->id = $this->formSave($button, "Uživatel byl úspěšně vytvořen.");
        $this->redirect('roles');
    }

    /**
     * @desc form add user to role handle
     */
    public function formAddUserToRoleSubmitted(NSubmitButton $button) {
        
        $this->standardFormSubmitted($button, "Uživatel přidán do role ".$button->getForm()->getValues()->name,
                                $this->getAction());
    }

    protected function createComponent($name) {
        switch ($name) {
            case "defaultActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addElement($this->link('new'), 'add', 'nový uživatel');
                return;
            case "editActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addElement($this->link('roles'), 'usergroups', 'členství ve skupinách');
                return;
            case "detailActionsMenu":
                $menu = $this->getComponentPrototype('menuPageActions', $name);

                $menu->addElement($this->link('edit', $this->id), 'edit', 'upravit');
                $menu->addElement($this->link('new'), 'add', 'nový uživatel');
                return;
            case "usersList":
                $t = new DsTable($this, $name);

                $t->setDataSource($this->modelUsers->dataSource());

                $t->addColumn('name', 'jméno', true);
                $t->addColumn('surname', 'příjmení', true);
                $t->addColumn('username', 'uživatelské jméno', true);


                $t->addActionPrototype(new WebAction('detail', $this->modelUsers, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('detail');

                //$t->addAction(new WebAction('roles', $this->modelUsers, $this), 'id', 'usergroups');

                $t->addActionPrototype(new WebAction('edit', $this->modelUsers, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('edit');

                $t->addActionPrototype(new WebAction('roles', $this->modelUsers, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('usergroups');

                $t->addActionPrototype(new WebAction('delete!', $this->modelUsers, $this))
                        ->addActionArgPrototype(array('id' => 'id'))
                        ->setIconName('delete')
                        ->setConfirmMessage('opravdu chcete uživatele smazat?');

                return;
            case "userRoles":
                $t = new TreeTable($this, $name);

                $t->setData($this->model->getRolesTree($this->id));

                $t->addColumn('name', 'název skupiny');
                $t->addActionPrototype(new WebAction('removeUserFromRole!', $this->modelUsers, $this, array('id' => $this->id)))
                        ->addActionArgPrototype(array('roleId' => 'id'))
                        ->setIconName('delete')
                        ->setConfirmMessage('opravdu chcete uživatele vyjmout z této skupiny?');
                return;
            case "formAddUserToRole":
                $form = new MyForm($this, $name);

                $form->addHidden('user_id')->setDefaultValue($this->id);

                $form->addSelect('role_id', 'přidat do skupiny:',
                        $this->modelRoles->getUserRoleTree()->getFormArray(), 10);

                $form->addSubmit('ok', 'přidat')
                        ->onClick[] = array($this, 'formAddUserToRoleSubmitted');

                $form->setHandle($this->modelUsers, 'addUserToRole');
                return;
            case "formNew":
                $form = $this->getFromFactory('formBase');
                $this->addComponent($form, $name);

                $form->setCurrentGroup();

                $form->addSubmit('ok', 'pokračovat')
                        ->onClick[] = array($this, 'formNewSubmitted');

                $form['ok']->getControlPrototype()->class('right');

                $form->addSubmit('cancel', 'zrušit')
                                ->setValidationScope('')
                        ->onClick[] = array($this, 'formCanceled');

                $form->setHandle($this->modelUsers, 'insert');

                RequestButtonHelper::prepareForm($form);
                return;
            default:
                parent::createComponent($name);
        }
    }

}