<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author martin
 */
interface IActionModel {

    /**
     * returns true if given action is possible in current context
     * @param Action $action
     * @return boolean
     */
    function isActionPossible(IAction $action);

    /**
     * executes action if possible, don't call it yourself.
     * @param $action
     * @return void
     * @throws ActionNotPossibleException
     */
    function action(IAction $action);
}