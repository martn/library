<?php

require_once CONTROLS_DIR . '/Base/BaseControl.php';

class Items extends BaseControl {
	 
	 
	public function render()
	{
		$template = $this->createTemplate();

		//$template->table = $table;

		$template->setFile(dirname(__FILE__) . '/list.phtml');
		$template->render();
	}
	 
}