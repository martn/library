<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2009 John Doe
 * @package    MyApplication
 * @version    $Id: BasePresenter.php 182 2008-12-31 00:28:33Z david@grudl.com $
 */
/**
 * Base class for all application presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */

require_once dirname(__FILE__).'/ActionHandlePresenter.php';

/**
 * @author martin
 *
 */
abstract class StandardPresenter extends ActionHandlePresenter {
    
    const STAGE_DEFAULT = 0;

    public $oldLayoutMode = FALSE;
    public $oldModuleMode = FALSE;
    
    /** @persistent */
    public $lang = '';
    public $backlink;
    public $user;
    public $id = NULL;
    
    /** @var translator */
    public $translator;
    public $stage;
    public $model;


    abstract protected function redirectItemError();

    
    public static function getPersistentParams() {
        return array_merge(parent::getPersistentParams(), array('backlink', 'id'));
    }

    
    /**
     * @desc sets language - gets lang from param, default is 'cs'
     */
    protected function setLang() {
        $l_a = Array('cs' => 'cs', 'cz' => 'cs', 'en' => 'en');

        if (array_key_exists($this->getParam('lang'), $l_a)) {
            $this->lang = $l_a[$this->getParam('lang')];
        } else {
            $this->lang = $l_a['cs'];
        }
    }



    /**
     * @desc function to test item
     */
    protected function itemValid($item, $redirect = false, $model = null) {
        if ($model === null)
            $model = $this->model;
        if (empty($item) | !$model->exists($item)) {
//settype($item, "integer");
            if ($redirect) {
                $this->redirectItemError();
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * @desc returns language
     */
    public function getLang() {
        return $this->lang;
    }

    /**
     * @desc returns current stage
     */
    public function getStage() {
        return $this->stage;
    }

    /**
     * @desc returns id of current user
     * @return unknown_type
     */
    public function getUserId() {
        return $this->getUser()->getIdentity()->id;
    }

    /**
     * @desc returns current stage
     */
    public function setStage($stage = self::STAGE_DEFAULT) {
        return $this->stage = $stage;
    }

    /**
     * @desc startup method
     */
    protected function startup() {
        parent::startup();

        $session = NEnvironment::getSession();
        if (!$session->isStarted()) {
            $session->start();
        }

        $this->setLang();

        $this->user = NEnvironment::getUser();

        $this->translator = new Translator($this->lang, LOCALE_DIR);

        $this->setStage();

        if($this->getAction() === 'default') $this->clearPersistentParams('id');
        $this->cleanupBackLink();
    }

    /**
     * @desc returns translator object
     */
    public function getTranslator() {
        return $this->translator;
    }

    
    
    
    /**
     * @desc stores something to session
     */
    public function saveVariable($key, $value, $sessionName) {
        return Utils::saveVariable($key, $value, $sessionName);
    }
    
    
    
    /**
     * clears variable from session
     * @param type $key
     * @param type $sessionName 
     */
    public function clearVariable($key, $sessionName) {
        return Utils::clearVariable($key, $sessionName);
    }

    
    
    /**
     * @desc returns value from session, throws NotFoundException if not defined.
     */
    public function loadVariable($key, $sessionName) {
        return Utils::loadVariable($key, $sessionName);
    }

    /**
     * @desc stores ordering key acc to give session nema
     */
    public function setOrderBy($orderKey, $sessionName) {
        $this->saveVariable('ord', $orderKey, $sessionName);
    }

    /**
     * @desc returns ordering key acc to given session name,
     * returns false if no order defined.
     */
    public function getOrderBy($sessionName) {
        try {
            return $this->loadVariable('ord', $sessionName);
        } catch (NotFoundException $e) {
            return false;
        }
    }

    /**
     * @desc search bots does not index this section
     */
    protected function robotsNoIndex() {
        $this->template->robots = "noindex, follow";
    }

    public function isAllowed($resource, $privilege) {
// test for superadmin is automatic in MyUser class
        return $this->user->isAllowed($resource, $privilege);
    }

    /**
     * @desc clears defined params
     * @param array $params
     * @return unknown_type
     */
    protected function clearPersistentParams() {
        foreach (func_get_args () as $param) {
            if(is_array($param)) {
                foreach ($param as $param_item) {
                    $this->$param_item = NULL;
                }
            } else {
                $this->$param = NULL;
            }
        }
    }

    /**
     * set back link (Presenter:view) (persistent parameter)
     * @param string $link
     */
    protected function setBackLink($link) {
        if(count(explode(":", $link)) < 2)
            $link = $this->getPresenterName().":".$link;
        
        $this->backlink = $link;
    }

    /**
     * returns backlink or $default value if no backlink set
     * @param string $default
     * @return string
     */
    protected function getBackLink($default = 'default') {
        return $this->backlink ? $this->backlink : $default;
    }

    
    protected function clearBackLink() {
        $this->clearPersistentParams('backlink');
    }

    
    /**
     * cleans up backlink - sets to NULL if this is the linked Presenter:view
     */
    protected function cleanupBackLink() {
        if (!empty($this->backlink)) {

            $link = explode(":", $this->backlink);

            switch (count($link)) {
                case 3:  // includes module
                    $this->backlink = $link[1] . ":" . $link[2];
                    break;
                case 2:  // Presenter:view
                    if (NString::lower($this->getBackLink()) === NString::lower($this->getPresenterName().":".$this->getAction())) {
                        $this->clearBackLink();
                    }
                    break;
                default:
                    $this->clearBackLink();
                    break;
            }
        }
    }


    
    /**
     * @desc returns name of the presenter (without module)
     */
    protected function getPresenterName() {
        $parse = explode(':', $this->getName());

        if (count($parse) > 1) {
            $link = $parse[1];
        } else {
            $link = $parse[0];
        }

        return strtolower($link);
    }


    
    protected function beforeRender() {
        parent::beforeRender();

        $this->template->setTranslator($this->translator);

        $this->template->lang = $this->lang;
        $this->template->presenter = $this;
        $this->template->id = $this->id;
    }

}

class InvalidBacklinkException extends Exception {
    
}
