<?php
                                        
require_once dirname(__FILE__) . '/Base/BasePresenter.php';

final class Front_LoginPresenter extends Front_BasePresenter {
    
    function renderDefault() {
        $this->addTitle("Přihlášení uživatele");
    }
} 