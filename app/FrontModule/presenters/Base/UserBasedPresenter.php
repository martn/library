<?php

require_once dirname(__FILE__) . '/BasePresenter.php';

abstract class Front_UserBasedPresenter extends Front_BasePresenter {

    public function startup() {
        parent::startup();

        $this->model = $this->modelUsers;
    }

    /**
     * @desc returns true if username exists
     *  used for username form test
     */
    public function usernameUnique($control) {
        if (!empty($this->id)) {
            if ($this->modelUsers->find($this->id)->username === $control->value)
                return true;
        }
        return!$this->modelUsers->userExists($control->value);
    }

    
    /**
     * @desc new form handle
     */
    public function formEditSubmitted(NSubmitButton $button) {
        $this->standardFormSubmitted($button, "Záznam byl upraven.");
    }




    
    public function formPasswordSubmitted(NSubmitButton $button) {
        $this->formSave($button, 'Heslo bylo změněno.');
        RequestButtonHelper::redirectBack();
    }




    function formPasswordCanceled(NSubmitButton $button) {
        RequestButtonHelper::redirectBack();
    }

  
    
    function beforeRender() {
        parent::beforeRender();
        if (!empty($this->id)) {
            $this->template->userdata = $this->modelUsers->find($this->id);
        }
    }


    
    function actionPassword() {
        $this->actionCheck(new WebAction('password', $this->modelUsers,
                        $this, array('id' => $this->id)));
    }


    /**
     * returns common component, not attached
     * @param string $name
     * @return unknown_type
     */
    protected function getFromFactory($name) {
        switch ($name) {
            case "formBase":
                $form = new MyForm();

                $form->addHidden('id');

                $form->addGroup('Jméno a příjmení');
                $form->addText('name', 'jméno:')->addRule(NForm::FILLED, 'jméno je povinné');
                $form->addText('surname', 'příjmení:')->addRule(NForm::FILLED, 'příjmení je povinné');

                $form->addText('usernm', 'uživatelské jméno:')
                        ->addRule(NForm::FILLED, 'Prosím vyplňte uživatelské jméno.')
                        ->addRule(array($this, 'usernameUnique'), 'Uživatelské jméno již existuje, prosím zvolte jiné.');

                $form->addGroup('heslo');
                $form->addPassword('psw', 'heslo:')
                        ->addRule(NForm::FILLED, 'Prosím, vyplňte heslo');

                $form->addPassword('psw2', 'heslo znovu:')
                        ->addRule(NForm::FILLED, 'Prosím, vyplňte potvrzení hesla')
                        ->addConditionOn($form['psw'], NForm::VALID)
                        ->addRule(NForm::EQUAL, 'Hesla se neshodují.', $form['psw']);

                $gr = $form->addGroup('kontakt');

                $form->addText('mail', 'e-mail:')
                        ->setEmptyValue('@')
                        ->addCondition(NForm::FILLED) // conditional rule: if is email filled, ...
                        ->addRule(NForm::EMAIL, 'e-mail není platný'); // ... then check email

                $form->addText('tel', 'telefon:');
                $form->addText('web', 'web:');
                $form->addTextArea('adress', 'adresa:', 30, 4);

                return $form;
            default:
                return parent::getFromFactory($name);
        }
    }

    protected function createComponent($name) {
        switch ($name) {
            case "formPassword":
                $form = new MyForm($this, $name);

                $form->addHidden('id')->setDefaultValue($this->id);

                $form->addPassword('psw', 'heslo:')
                        ->addRule(NForm::FILLED, 'Prosím, vyplňte heslo');

                $form->addPassword('psw2', 'heslo znovu:')
                        ->addRule(NForm::FILLED, 'Prosím, vyplňte potvrzení hesla')
                        ->addConditionOn($form['psw'], NForm::VALID)
                        ->addRule(NForm::EQUAL, 'Hesla se neshodují.', $form['psw']);

                $form->addSubmit('ok', 'uložit')
                        ->onClick[] = array($this, 'formPasswordSubmitted');

                $form->addSubmit('cancel', 'zrušit')
                                ->setValidationScope(NULL)
                        ->onClick[] = array($this, 'formPasswordCanceled');

                $form->setHandle($this->modelUsers, 'update');

                RequestButtonHelper::prepareForm($form);

                return;
            case "formEdit":
                $form = $this->getFromFactory('formBase');
                $this->addComponent($form, $name);

                foreach ($form->getGroup('heslo')->getControls() as $control) {
                    $form->removeComponent($control);
                }

                $form->setCurrentGroup($form->getGroup('heslo'));
                $form->addRequestButton('change_password', 'změnit heslo', 'password');

                //$form->addGroup('');
                //$form->addRequestButton('change_password', 'změnit heslo', 'password');

                $form->setCurrentGroup();

                $form->addSubmit('ok', 'uložit')
                        ->onClick[] = array($this, 'formEditSubmitted');

                $form['ok']->getControlPrototype()->class('right');

                $form->addSubmit('cancel', 'zrušit')
                                ->setValidationScope('')
                        ->onClick[] = array($this, 'formCanceled');


                $form->setHandle($this->modelUsers, 'update');

                $data = $this->modelUsers->find($this->id);
                $form->setValues($data);
                $form->setValues(array('usernm' => $data['username']));


                RequestButtonHelper::prepareForm($form);
                return;
            default:
                parent::createComponent($name);
        }
    }

}

