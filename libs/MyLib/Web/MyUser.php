<?php

require_once LIBS_DIR . '/Nette/Web/User.php';

class MyUser extends NUser 
{
	
	/**
	 * (non-PHPdoc)
	 * @see scripts/libs/Nette/Web/User#isAllowed($resource, $privilege)
	 */
	public function isAllowed($resource = NULL, $privilege = NULL)
	{
		if($this->isInRole('superadmin')) return true;
		
		return parent::isAllowed($resource, $privilege);
	}
	
}