<?php
interface IAction {
	
	
	/**
	 * sets model related to the action
	 * @param IModel $model
	 */
	function setModel(IActionModel $model);
	

        /**
         * returns object clone
         */
        function getClone();

	
	/**
	 * returns action model
	 * @return IModel 
	 */
	function getModel();
	
	
	/**
	 * sets name of the action
	 * @param string $name
	 */
	function setName($name);
	
	
	/**
	 * returns name of the action 
	 */
	function getName();
	
	
	/**
	 * returns action arguments
	 * @return array
	 */
	function getArgs();

        /**
         * returns action argument according to given key
         * @return mixed
         */
        function getArgument($key);
	
	
	/**
	 * returns true if action is possible
	 * @return boolean
	 */
	function isPossible();
	
	
	/**
	 * executes action
	 * @return unknown_type
	 * @throws ActionNotPossibleException
	 */
	function execute();
	
	
}