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
require_once LIBS_DIR . '/MyLib/Application/StandardPresenter.php';

abstract class BasePresenter extends StandardPresenter {
    const INPUT_WIDTH = 24;

    const RESOURCE_ACCOUNT = 'account';
    const RESOURCE_GROUPS = 'groups';
    const RESOURCE_SECTIONS = 'sections';
    const RESOURCE_TYPES = 'types';
    const RESOURCE_USERS = 'users';
    const RESOURCE_MAPS = 'maps';

    const PRIVILEGE_VIEW = 'view';
    const PRIVILEGE_EDIT = 'edit';

    protected $modelPrivileges;
    protected $modelAcl;
    protected $modelSections;
    protected $modelAttributes;
    protected $modelAttributesGroups;
    protected $modelTypes;
    protected $modelFiles;
    protected $modelRoles;
    protected $modelMaps;
    protected $modelMenus;
    protected $modelMapItems;
    protected $modelMenuItems;
    protected $modelItems;
    protected $modelUsers;

    /**
     * @desc startup method
     */
    protected function startup() {
        parent::startup();

        BaseModel::setLang($this->getLang());
        BaseControl::setLang($this->getLang());

        BaseControl::setTranslator($this->getTranslator());

        //$this->modelAcl = new Pokus();
        $this->modelAcl = new AclModel();
        $this->modelPrivileges = new PrivilegesModel();
        $this->modelSections = new Sections();
        $this->modelAttributes = new AttributesModel();
        $this->modelAttributesGroups = new AttributesGroupsModel();
        $this->modelTypes = new TypesModel();
        $this->modelFiles = new FilesModel();
        $this->modelRoles = new Roles();
        $this->modelMaps = new Maps(Maps::TYPE_MAP);
        $this->modelMenus = new Maps(Maps::TYPE_MENU);
        $this->modelMapItems = new MapItems(Maps::TYPE_MAP);
        $this->modelMenuItems = new MapItems(Maps::TYPE_MENU);
        $this->modelItems = new ItemsModel();
        $this->modelUsers = new UsersModel();

        
        
        
//        NFormContainer::extensionMethod('NFormContainer::addJSelect', callback('JSelectBox::addJSelect'));

        if (!$this->userAdmitted()) {
            $this->redirectNotAllowed();
        }
    }

    protected function redirectItemError() {
        $this->flashMessage('Neplatná položka.', 'error');
        $this->redirect('default');
    }

    private function isLoginScreen() {
        if ($this->getAction(true) === ':Front:Login:default') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @desc tests if current user has specific privilege to
     * control respective resource
     */
    public function userAdmitted() {
        //  return true;

        if ($this->isLoginScreen())
            return true;

        try {
            $sectionId = $this->modelSections->sectionIdFromPresenter($this);

            return $this->modelSections->userAdmitted($sectionId);
        } catch (NotFoundException $e) {
            //Debug::dump('prdel');
            return true;
        }
    }

    /**
     * @desc redirect method for non authorized user
     */
    protected function redirectNotAllowed() {
        if ($this->user->isAuthenticated())
            $this->flashMessage('Chyba oprávnění.', 'error');

        $this->redirect('login:default');
    }



    
    protected function beforeRender() {
        parent::beforeRender();

        if (!$this->user->isLoggedIn()) {

            $this->template->loginForm = $this->getComponent('loginForm');
            $this->template->userAuthenticated = false;
        } else {
            $this->template->user = $this->user->getIdentity();
            $this->template->userAuthenticated = true;
        }



        //   $a  = new WebAction("edit", $this->modelUsers, $this);
        //   $a->addArgs(array("prdel" => "kozy", "prdel2" => "kozy2"));
        //   print_r($a->getArgs());
        //$this->flashMessage();
    }

    /**
     * @desc login form handler
     */
    public function loginFormSubmitted($form) {
        try {
            $this->user->login($form['f1']->getValue(), $form['f2']->getValue());
            $this->getApplication()->restoreRequest($this->backlink());
            $this->redirect('Default:default');
        } catch (AuthenticationException $e) {
            $this->flashMessage($e->getMessage(), 'error');
            //$form->addError($e->getMessage());
        }
    }

    /**
     * adds a string to the header
     * @param <type> $string
     */
    protected function addTitle($string) {
        $this->getComponent("header")->addTitle($string);
    }

    /**
     * @desc common elements factory
     */
    public function getElement($name) {
        $im_folder = NEnvironment::getVariable('baseUri') . "images/";
        $icons_folder = $im_folder . "icons/";
        switch ($name) {
            case 'icon':
                $icon = NHtml::el("img");
                $icon->class = "icon";
                return $icon;
            case 'usergroups_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "usergroups-small.png";
                $icon->alt = "uživatelské skupiny";
                $icon->title = "uživatelské skupiny";
                return $icon;
            case 'usergroups_icon_medium':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "usergroups-medium.png";
                $icon->alt = "uživatelské skupiny";
                $icon->title = "uživatelské skupiny";
                return $icon;
            case 'unlocked_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "unlocked-small.png";
                $icon->alt = "odemčeno";
                $icon->title = "odemčeno";
                return $icon;
            case 'download_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "download-small.png";
                $icon->alt = "stáhnout";
                $icon->title = "stáhnout";
                return $icon;
            case 'download_icon_medium':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "download-medium.png";
                $icon->alt = "stáhnout";
                $icon->title = "stáhnout";
                return $icon;
            case 'ok_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "ok-small.png";
                $icon->alt = "hotovo";
                $icon->title = "hotovo";
                return $icon;
            case 'ok_icon_medium':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "ok-medium.png";
                $icon->alt = "hotovo";
                $icon->title = "hotovo";
                return $icon;
            case 'locked_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "locked-small.png";
                $icon->alt = "zamčeno";
                $icon->title = "zamčeno";
                return $icon;
            case 'configure_icon_medium':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "configure-medium.png";
                $icon->alt = "nastavení";
                $icon->title = "nastavení";
                return $icon;
            case 'configure_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "configure-small.png";
                $icon->alt = "nastavení";
                $icon->title = "nastavení";
                return $icon;
            case 'delete_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "delete-small.png";
                $icon->alt = "smazat";
                $icon->title = "smazat";
                return $icon;
            case 'delete_icon_medium':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "delete-medium.png";
                $icon->alt = "smazat";
                $icon->title = "smazat";
                return $icon;
            case 'edit_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "edit-small.png";
                $icon->alt = "upravit";
                $icon->title = "upravit";
                return $icon;
            case 'edit_icon_medium':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "edit-medium.png";
                $icon->alt = "upravit";
                $icon->title = "upravit";
                return $icon;
            case 'add_icon_medium':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "add-medium.png";
                $icon->alt = "přidat";
                $icon->title = "přidat";
                return $icon;
            case 'add_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "add-small.png";
                $icon->alt = "přidat";
                $icon->title = "přidat";
                return $icon;
            case 'application_icon_medium':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "application-medium.png";
                $icon->alt = "upravit";
                $icon->title = "upravit";
                return $icon;
            case 'application_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "application-small.png";
                $icon->alt = "přístupová práva";
                $icon->title = "přístupová práva";
                return $icon;
            case 'up_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "up-small.png";
                $icon->alt = "nahoru";
                $icon->title = "nahoru";
                return $icon;
            case 'down_icon_small':
                $icon = $this->getElement('icon');
                $icon->src = $icons_folder . "down-small.png";
                $icon->alt = "dolů";
                $icon->title = "dolů";
                return $icon;
            default:
                return null;
        }
    }

    /*
     * @desc returns Paginator from component visualPaginator
     * @return Paginator
     *
     */

    protected function getPaginator() {
        return $this->getComponent('visualPaginator')->getPaginator();
    }

    /**
     * @desc prepares both paginator and datasource
     * @param DibiDataSource $ds
     * @return DibiDataSource
     */
    protected function preparePaginator(DibiDataSource $ds) {
        $this->getPaginator()->setItemCount($ds->count());

        $ds->applyLimit($this->getPaginator()->getLength(),
                $this->getPaginator()->getOffset());
        return $ds;
    }

    /**
     * filter to pack javascript
     * @param unknown_type $code
     * @return unknown_type
     */
    public function packJs($code) {
        $packer = new JavaScriptPacker($code, "None");
        return $packer->pack();
    }

    protected function createComponent($name) {
        switch ($name) {
            case "pageNavigator":
                $chain = $this->modelMapItems->getChainFromPresenter($this, 'map');

                $navigator = new NavigatorControl();
                $navigator->setData($chain);

                $this->addComponent($navigator, $name);
                return;
            case "mainMenu":
                $menu = new MenuControl();

                $this->modelMenuItems->setMapIdentificator('mainmenu');

                $menu->setMap($this->modelMenuItems->getTree());
                $menu->setLayout('mainmenu');

                $this->addComponent($menu, $name);
                return;
            case "loginForm":
                $form = new MyForm($this, $name);
                $form->addText('f1', 'uživatelské jméno:')
                        ->addRule(NForm::FILLED, 'Prosím, zadejte uživatelské jméno.');

                $form->addPassword('f2', 'heslo:')
                        ->addRule(NForm::FILLED, 'Prosím, zadejte heslo.');

                $form->addSubmit('login', ' přihlásit ');
                $form->onSubmit[] = array($this, 'loginFormSubmitted');

                $form->addProtection('Prosím, přihlaste se znovu (výstraha zabezpečeení)');
                return;
            case "header":
                $header = new HeaderControl(HeaderControl::HTML_5, 'cz', 'Knihovna');
                $this->addComponent($header, $name);

                $header->setTitleSeparator(' | ')
                        ->setTitlesReverseOrder(true)
                        ->addKeywords(array('knihovna'))
                        ->setDescription('Knihovna')
                        ->setRobots('index,follow'); //of course ;o)
                //CssLoader
                $css = $header['css'];
                // při development módu vypne spojování souborů
                $css->joinFiles = NEnvironment::isProduction();
                // cesta na disku ke zdroji
                $css->sourcePath = WWW_DIR . "/css";

                $css->sourceUri = NEnvironment::getVariable('baseUri') . 'css';
                $css->tempUri = NEnvironment::getVariable("baseUri") . "webtemp";
                // cesta na disku k cílovému adresáři
                $css->tempPath = WWW_DIR . "/webtemp";

                //JavascriptLoader
                $js = $header['js'];
                $js->tempUri = NEnvironment::getVariable("baseUri") . "webtemp";
                $js->tempPath = WWW_DIR . "/webtemp";
                $js->sourcePath = WWW_DIR . "/js";

                // při development módu vypne spojování souborů
                $js->joinFiles = NEnvironment::isProduction();

                if (NEnvironment::isProduction()) {
                    $js->filters[] = array($this, "packJs");
                }

                return;
            default:
                parent::createComponent($name);
                return;
        }
    }

}
