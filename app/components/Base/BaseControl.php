<?php

require_once LIBS_DIR . '/MyLib/Application/StandardControl.php';

abstract class BaseControl extends StandardControl {

    /** @var stage */
    protected $stage;
    protected $htmlClass = '';
    /** @var DibiDataSource */
    protected $dataSource;

    const STAGE_DEFAULT = 0;
    const STAGE_EDIT_PASSWORD = 1;



    abstract function render();

    /**
     * renders control
     * @return unknown_type
     */
    //abstract function render();

    /**
     * @param IComponentContainer $parent
     * @param unknown_type $name
     * @return unknown_type
     */
    public function __construct(IComponentContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);

        $this->setStage(self::STAGE_DEFAULT);

        $this->template = $this->createTemplate();
    }

    /* (non-PHPdoc)
     * @see scripts/libs/MyLib/Application/StandardControl#createTemplate()
     */

    protected function createTemplate() {
        $template = parent::createTemplate();

        $template->class = $this->getHtmlClass();

        return $template;
    }

    /**
     * sets data source
     * @param DibiDataSource $ds
     * @return unknown_type
     */
    function setDataSource(DibiDataSource $ds) {
        $this->dataSource = $ds;
    }

    /**
     * returns data source
     * @return unknown_type
     */
    function getDataSource() {
        return $this->dataSource;
    }

    /**
     * renders to string
     * @return string
     */
    public function __toString() {
        ob_start();
        $this->render();
        return ob_get_clean();
    }

    /**
     * adds a class to the table
     * @param string $class
     * @return unknown_type
     */
    public function setHtmlClass($class) {
        $this->htmlClass .= " $class";
        return $this;
    }

    /**
     * returns html class
     * @return string
     */
    public function getHtmlClass() {
        return $this->htmlClass;
    }

    /**
     * @desc returns current stage
     */
    public function getStage() {
        return $this->stage;
    }

    /**
     * @desc sets a stage
     */
    public function setStage($stage) {
        return $this->stage = $stage;
    }

    /**
     * @desc common elements factory
     */
    public function getElement($name) {
        return $this->getPresenter()->getElement($name);
    }

}