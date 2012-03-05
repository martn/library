<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author martin
 */
interface IActionGenerator {
    
    /**
     * adds Action prototype to be generated from
     */
    function addActionPrototype(IWebAction $action);


    /**
     * adds argument prototype(s) (key => data_column) to Action Prototype
     */
    function addActionArgPrototype(array $arg);


    /**
     * adds static arguments to Action prototype
     */
    function addActionArgStatic(array $staticArg);

    
    /**
     * make action ajax attribute true/false
     */
    function setAjax($ajax = true);



    /**
     * sets name (identificator) of used icon
     */
    function setIconName($name);



    /**
     * sets confirm message if confirm needed
     */
    function setConfirmMessage($confirmMessage = NULL);



    /**
     * returns number of actions 
     */
    function countActions();
}