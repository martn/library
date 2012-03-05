<?php

require_once dirname(__FILE__) . '/Base/ItemsBasePresenter.php';

class Front_SearchPresenter extends Front_ItemsBasePresenter {
    const SEARCH_SIGNATURE = 'sign';
    const SEARCH_ADVANCED = 'adv';
    const SEARCH_FULLTEXT = 'ful';

    public $searchType = null;

    public function startup() {
        parent::startup();
    }

    // ================== HANDLERS ===================

    /*
      public static function getPersistentParams() {
      return array('item');
      } */

    
    
    

    public function renderDefault() {

        switch ($this->searchType) {
            case self::SEARCH_SIGNATURE:

                break;
            case null:
            default:
                break;
        }

        
        if (!empty($this->dataSource)) {
            $table = $this->getResultTable($this->dataSource);

            $this->template->table = $table;

            $this->template->count = $this->dataSource->count();
            //$table
        }
    }

    
    
    
    // ============= obsluhy ===================

    /**
     * @desc new form submitted
     */
    public function searchSignature(SubmitButton $button) {
        $data = $button->getForm()->getValues();

        $this->dataSource = $this->modelItems->getDataSource(
                        $this->modelItems->signatureToId($data['signature']));

        $this->searchType = self::SEARCH_SIGNATURE;
    }

    
    
    
    /**
     * @desc new form submitted
     */
    public function searchFulltext(SubmitButton $button) {
        $data = $button->getForm()->getValues();

        $this->dataSource = $this->modelItems->fulltextSearch($data['fulltext']);

        $this->searchType = self::SEARCH_FULLTEXT;
    }

    
    
    function createTabFulltext($name, Tab $tab) {
        $form = new MyForm($tab, $name);
        $form->addGroup();
        $form->addText("fulltext", "název:");

        $form->setCurrentGroup(null);
        $form->addSubmit("search", "Hledat")
                ->onClick[] = array($this, "searchFulltext");
        return $form;
    }

    
    
    
    /**
     * @desc returns true if signature valid
     */
    public function signatureValid(FormControl $control) {
        $data = $control->getForm()->getValues();

        if (!$this->modelTypes->signatureValid($data['signature'])) {
            $this->flashMessage("Signatura je neplatná.", "error");
            return false;
        } else {
            return true;
        }
    }

    
    
    
    function createTabSignature($name, Tab $tab) {
        $form = new MyForm($tab, $name);

        $form->addGroup();
        $form->addText("signature", "signatura")
                ->addRule(Form::FILLED, "Něco je povinné!")
                ->addRule(array($this, 'signatureValid'), "");

        $form->setCurrentGroup(null);
        $form->addSubmit("search", "vyhledat")
                ->onClick[] = array($this, "searchSignature");
        return $form;
    }
    
    
    

    protected function createComponent($name) {
        switch ($name) {
            case "searchTabControl":
                $tc = new TabControl($this, $name);
                $tc->mode = TabControl::MODE_PRELOAD;
                $tc->sortable = false;
                //$tc->jQueryTabsOptions = "{ fx: { height: 'toggle',opacity:'toggle',marginTop:'toggle',marginBottom:'toggle',paddingTop:'toggle',paddingBottom:'toggle'} }";
                //$tc->handlerComponent = $this; // Is automatic
                //$tc->loaderText="Načítám...";

                $t = $tc->addTab("fulltext");
                $t->header = "Fulltext";
                $t->contentFactory = array($this, "createTabFulltext");
                //$t->hasSnippets = true; // Potřeba nastavit u každého tabu, ve kterém budou snippety! Jinak nebude fungovat AJAX! Má stejnou funkci jako @ v šablonách

                $t = $tc->addTab("signature");
                $t->header = "Podle signatury";
                $t->contentFactory = array($this, "createTabSignature");

                return;
            default:
                parent::createComponent($name);
                return;
        }
    }

    
    
    /* ### Handlery k odkazů v sekci Externí ovládání TabControlu ### */

    function handlePrepniNa($tab) {
        $this["tabs"]->select($tab);
        if (!$this->isAjax())
            $this->redirect("this");
    }

    function handlePrekresli($tab) {
        $this["tabs"]->redraw($tab);
    }

}
