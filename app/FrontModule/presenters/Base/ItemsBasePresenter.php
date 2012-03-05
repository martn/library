<?php

require_once dirname(__FILE__) . '/BasePresenter.php';

class Front_ItemsBasePresenter extends Front_BasePresenter {

    public $type;
    protected $data;
    // Dokud se neopraví: http://forum.nettephp.com/cs/2301-dalsi-nekonecny-cyklus-canonicalize
    public $autoCanonicalize = FALSE;
    protected $dataSource;
    protected $rules;


    public function startup() {
        parent::startup();

        $this->model = $this->modelItems;
    }


    function handleDelete($token) {
        parent::handleDelete($token);
    }


    function formFilterSubmitted(NSubmitButton $button) {
        $this->saveFilterRules($button->getForm()->getValues());
        //$this->dataSource = $this->model->getFilteredItems($values);
        
    }


    function saveFilterRules($rules) {
        foreach($rules as $key=>$value) {
            $this->saveVariable($key, $value, 'searchFilter');
        }
    }


    function loadFilterRules() {
        $rules = array();
        foreach($this->getSession('searchFilter') as $key => $value) {
            $rules[$key] = $value;
        }
        return $rules;
    }


    /**
     * renders group name as anchor to the list of users
     * @param string $content
     * @param Traversable $data
     * @return string
     */
    function userNameRenderer($standardContent, $rowData) {
        $user = $this->modelUsers->find($rowData->user_id);
        return $user->name." ".$user->surname;
    }

    /**
     * renders group name as anchor to the list of users
     * @param string $content
     * @param Traversable $data
     * @return string
     */
    function itemAnchorRenderer($standardContent, $rowData) {
        return NHtml::el('a')->href($this->link('detail', $rowData->id))->setText($standardContent);
    }


    
    function signatureRenderer($standardContent, $rowData) {
        return $this->model->getSignature($rowData);
    }

    
    
    protected function createComponent($name) {
        switch ($name) {
            case "formFilter":
                $form = new MyForm($this, $name);
                $form->getElementPrototype()->class = "formFilter";
                
                $form->addGroup('fulltext');
                $form->addText('fts','hledat');

                
                $form->addSubmit('ok1', 'hledat')
                        ->onClick[] = array($this, 'formFilterSubmitted');
                
                $form->addGroup('vlastník')->setOption('visual', 'visible');
                $control = $form->addSelect('user_id', 'vlastník',
                                $this->modelUsers->getSelectBoxArray());

                if($this->user->isLoggedIn()) {
                    $control->setDefaultValue($this->user->getIdentity()->data['id']);
                } 

                $form->addGroup('výběr typu');

                foreach ($this->modelTypes->dataSource() as $type) {
                    $form->addCheckbox('type' . $type->id, $type->name);

                }

                $form->setCurrentGroup();
                
                $form->addSubmit('ok', 'hledat')
                        ->onClick[] = array($this, 'formFilterSubmitted');
                return;
            case "resultTable":
                $table = new DsTable($this, $name);

                $table->addColumn('name','název',true)
                     ->setRenderer(array($this, 'itemAnchorRenderer'));

                $table->addColumn('type_name','typ položky',true);

                $table->addColumn('user_id','vlastník')
                    ->setRenderer(array($this, 'userNameRenderer'));

                $table->addColumn('signature_definition', 'signatura')
                     ->setRenderer(array($this, 'signatureRenderer'));

                $table->addActionPrototype(new WebAction('edit', $this->model))
                       ->addActionArgPrototype(array('id'=>'id'))
                        ->addActionArgStatic(array('backlink' => $this->getAction()))
                       ->setIconName('edit');

                $table->addActionPrototype(new WebAction('delete!', $this->model))
                       ->addActionArgPrototype(array('id'=>'id'))
                       ->addActionArgStatic(array('backlink'=>$this->getAction()))
                       ->setIconName('delete')
                        ->setConfirmMessage("Opravdu chcete smazat tuto položku?");

                $table->paginatorOn();
                return;
            default:
                parent::createComponent($name);
                return;
        }
    }

}
