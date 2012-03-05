<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class QuickActionsMenu extends QuickMenu {

    protected static $ACTIONS_NAMESPACE = 'actions';



    function addActionElement(WebAction $action, $icon, $text = '', $attrs = '') {
        parent::addElement($action->getLink(), $icon, $text, $attrs);
        $this->storeAction($this->getCurrent(), $action);
        return $this;
    }


    
    public function addElement($link, $icon, $text = '', $attrs = '') {
        parent::addElement($link, $icon, $text, $attrs);
        $this->storeAction($this->getCurrent());
        return $this;
    }


    private function storeAction($element, WebAction $action = NULL) {
        $this->addObject(array('element' => $element,
                            'action' => $action),
                self::$ACTIONS_NAMESPACE);
    }

    
    protected function getElements() {

        foreach ($this->getObjects(self::$ACTIONS_NAMESPACE) as $object) {
            if($object['action'] === NULL) {

                $this->addObject($object['element'],
                        'output');

            } else if($object['action']->isPossible()) {

                $this->addObject($object['element'],
                        'output');
            }
        }

        return $this->getObjects('output');
    }

}