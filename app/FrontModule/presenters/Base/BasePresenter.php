<?php

require_once APP_DIR . '/presenters/BasePresenter.php';

/**
 * Base class for all application presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */
abstract class Front_BasePresenter extends BasePresenter {
   
    /**
     * @desc default form canceled handle
     */
    public function formCanceled(NSubmitButton $button) {
        $this->redirect($this->getBackLink());
    }


    /**
     *  saves form and returns the result
     * @param NSubmitButton $button
     */
    protected function formSave(NSubmitButton $button, $message = 'Data uložena.') {
        try {
            $retval = $button->getForm()->save();

            $this->flashMessage($message, 'ok');
        } catch (ActionNotPossibleException $e) {
            $this->flashMessage('Akce není možná.', 'error');
            $retval = NULL;
        }

        return $retval;
    }
    
    /**
     * @desc select data submitted
     */
    public function formSubmitted(NSubmitButton $button) {
        return $this->standardFormSubmitted($button);
    }



    protected function standardFormSubmitted(NSubmitButton $button, $message = 'Data uložena.', $redirect = 'default') {
        $retval = $this->formSave($button, $message);

        if(!empty($redirect)) $this->redirect($redirect !== 'default' ? $redirect : $this->getBackLink($redirect));
        return $retval;
    }

    
    /**
     * @desc action edit - test
     */
    public function actionEdit($id) {
        $this->actionCheck(new WebAction('edit', $this->model, $this, array('id' => $id)));
    }



    function actionDetail($id) {
        $this->actionCheck(new WebAction('view', $this->model, $this, array('id' => $id)));
    }


    function actionNew($id) {
        $this->actionCheck(new WebAction('new', $this->model, $this, array('id' => $id)));
    }


    /**
     * @desc returns true if user is allowed to handle item of given id or data array
     * @param unknown_type $id
     * @return unknown_type
     */
/*    public function isAllowedToHandle($id) {
        $this->modelItems->
        if (is_numeric($id)) {
            try {
                $id = $this->modelItems->find($id);
            } catch (NotFoundException $e) {
                return false;
            }
        }

        if ($this->user->isAuthenticated()) {

            // TODO: this needs to be updated (privileges)
            if ($id->user_id == $this->user->getIdentity()->data['id']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }*/

    /**
     * @desc handles delete signal
     */
    public function handleMoveUp($token) {
        $this->signalHandle();
    }

    /**
     * @desc handles delete signal
     */
    public function handleMoveDown($token) {
        $this->signalHandle();
    }
    

    public function handleDelete($token) {
        $this->signalHandle("Položka byla smazána.");
    }

    /**
     * standard action handle
     * @return unknown_type
     */
    protected function signalHandle($successMessage = NULL, $failMessage = "Akce není možná.", $invalidateSnippet = NULL) {
        $retval = parent::signalHandle($successMessage, $failMessage);

        if ($this->isAjax()) {
            if(!empty($invalidateSnippet)) {
                $this->invalidateControl($invalidateSnippet);
            } else {
                $this->invalidateControl('mainPanel');
            }
        } else {
            $this->redirect($this->backlink());
        }
    }

    /**
     * @desc returns true if control without spaces
     */
    public function ruleWithoutSpaces(NFormControl $control) {
        $data = $control->getValue();
        if (strpos($data, " ")) {
            return false;
        } else {
            return true;
        }
    }

    
    /**
     * returns common component, not attached  
     * @param string $name
     * @return unknown_type
     */
    protected function getFromFactory($name) {
        switch ($name) {
            case "menuPageActions":
                $menu = new QuickActionsMenu();

                $menu->setHtmlClass('vertical');
                $menu->setSizeMedium();
                return $menu;
            default:
                return NULL;
        }
    }


    
    /**
     * returns common component prototype, atached to the presenter, if componentName presented.
     * @param string $name
     * @param string $componentName
     * @return Component
     */
    protected function getComponentPrototype($name, $componentName = null) {
        $component = $this->getFromFactory($name);

        if ($componentName !== null)
            $this->addComponent($component, $componentName);

        return $component;
    }



    protected function createComponent($name) {
        switch ($name) {
            case "formFieldChangeType":
                $form = new MyForm($this, $name);
                $form->onSubmit[] = array($this, 'changeFieldType');

                $form->addGroup();

                $form->addSelect('type', 'Zvolte typ pole:', $this->modelAttributes->getFieldTypes())->controlPrototype->onchange("submit();");
                return;
            default:
                parent::createComponent($name);
                return;
        }
    }

}

