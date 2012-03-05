<?php
require_once dirname(__FILE__) . '/IAction.php';

interface IWebAction extends IAction {
	
	
	//function setContainer(IActionContainer $component)
	
	
	/**
	 * returns action link if it's possible
	 * @return string
	 * @throws ActionNotPossibleException
	 */
	function getLink();
	
	
	/**
	 * returns string encapsulation of action object
	 * @return string
	 */
	function getString();


        function setContainer(NPresenterComponent $container);

        function getContainer();
	
	
	/**
	 * returns new IWebAction object from PresenterComponent (implementing IActionContainer)
	 * from Action-generated signal
	 * @param IActionContainer $component
	 * @return IWebAction
	 * @throws InvalidSignalException
	 */
	static function fromSignal(IActionContainer $container);
}