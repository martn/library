<?php

require_once LIBS_DIR . '/Nette/Application/Control.php';

abstract class StandardControl extends NControl {

    /** @var $model */
    protected $model;
    /** @var id */
    public $id;
    /** @var lang */
    protected static $lang;
    protected $template;
    protected static $translator;

    /**
     * (non-PHPdoc)
     * @see scripts/libs/Nette/Application/Control#createTemplate()
     */
    protected function createTemplate() {
        $template = parent::createTemplate();
        // $template->registerFilter('Nette\Templates\CurlyBracketsFilter::invoke');

        $template->control = $this;

        $template->setTranslator(self::getTranslator());
        return $template;
    }

    /**
     * @desc returns full datetime in format
     * Sun, 02 Nov 2008 23:52:05 +0100
     */
    public function getRSSDatetime($datetime) {
        $DT = new DateTime($datetime);
        return $DT->format('D, d M Y H:i:s O');
    }

    /**
     * @desc removes all special characters from given string
     */
    public function removeSpecialCharacters($str) {
        return Utils::removeSpecialCharacters($str);
    }

    /**
     * @desc returns current id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @desc sets object id
     */
    public function setId($id) {
        return $this->id = $id;
    }

    /**
     * @desc sets lang to specified value
     */
    public static function setLang($lang) {
        return self::$lang = $lang;
    }

    /**
     * @desc returns lang
     */
    public function getLang() {
        return self::$lang;
    }

    /**
     * @desc stores ordering key acc to give session nema
     */
    public function setOrderBy($orderKey, $sessionName) {
        //echo $orderKey;

        $newOrd = array($orderKey);

        try {
            $ord = $this->getOrderBy($sessionName);

            if ($ord[1] == dibi::ASC) {
                array_push($newOrd, dibi::DESC);
            } else {
                array_push($newOrd, dibi::ASC);
            }
        } catch (NotFoundException $e) {
            array_push($newOrd, dibi::ASC);
        }
        return $this->saveVariable('ord', $newOrd, $sessionName);
    }

    /**
     * @desc returns ordering key acc to given session name,
     * returns false if no order defined.
     */
    public function getOrderBy($sessionName) {
        try {
            return $this->loadVariable('ord', $sessionName);
        } catch (NotFoundException $e) {
            throw $e;
        }
    }

    /**
     * @desc stores something to session
     */
    public function saveVariable($key, $value, $sessionName) {
        Utils::saveVariable($key, $value, $sessionName);
    }

    /**
     * @desc returns value from session, throws NotFoundException if not defined.
     */
    public function loadVariable($key, $sessionName) {
        return Utils::loadVariable($key, $sessionName);
    }

    /**
     * returns true if current user is allowed to...
     * @param $resource
     * @param $privilege
     * @return boolean
     */
    function userAllowed($resource = null, $privilege = null) {
        return Utils::userAllowed($resource, $privilege);
    }

    /**
     * @desc sets a default translator
     */
    public static function setTranslator(ITranslator $translator) {
        return self::$translator = $translator;
    }

    /**
     * @desc returns common translator
     */
    public static function getTranslator() {
        return self::$translator;
    }

}