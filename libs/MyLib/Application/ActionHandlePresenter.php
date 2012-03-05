<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


require_once LIBS_DIR . '/Nette/Application/Presenter.php';
require_once LIBS_DIR . '/MyLib/Action/IActionContainer.php';

/**
 * Description of ActionHandlePresenter
 *
 * @author martin
 */
class ActionHandlePresenter extends NPresenter implements IActionContainer {
    
    public $token;

    private $actionModel = NULL;
    private $actionName = NULL;


    protected function startup() {
        parent::startup();

        if(!$this->isSignalReceiver($this)) $this->clearActionString();
    }

    /* (non-PHPdoc)
     * @see scripts/libs/MyLib/IActionContainer#getActionString()
     */
    function getActionString() {
        return $this->token;
    }

    /* (non-PHPdoc)
     * @see scripts/libs/MyLib/IActionContainer#clearActionString()
     */

    function clearActionString() {
        $this->clearPersistentParams('token');
    }

    /* (non-PHPdoc)
     * @see scripts/libs/MyLib/IActionContainer#getActionVariableName()
     */

    function getActionVariableName() {
        return 'token';
    }



    function setActionModel(IActionModel $model) {
        $this->actionModel = $model;
    }


    function setActionName($name) {
        $this->actionName = $name;
    }


    static function  getPersistentParams() {
        return array('token');
    }

    
    /**
     * standard action handle
     * @return unknown_type
     */
    protected function signalHandle($successMessage = NULL, $failMessage = "Akce není možná.") {
        try {
            $action = WebAction::fromSignal($this);

            if(!empty($this->actionModel)) $action->setModel($this->actionModel);
            if(!empty($this->actionName)) $action->setName($this->actionName);

            $action->execute();

            if ($successMessage)
                $this->flashMessage($successMessage, 'ok');
            return true;
        } catch (ActionNotPossibleException $e) {
            $this->flashMessage($failMessage, "error");

            return false;
        }
    }

    /**
     * checks given action if possible and redirects/throws exception if not.
     * usable for action/view test...
     * @param Action $action
     * @return boolean
     * @throws ActionNotPossibleException
     */
    protected function actionCheck(Action $action, $redirect = true, $target = 'default') {
        if (!$action->isPossible()) {
            if ($redirect) {
                $this->flashMessage("Akce není možná.", "error");
                $this->redirect($target);
            } else {
                throw new ActionNotPossibleException();
            }
        } else {
            return true;
        }
    }

}