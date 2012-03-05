<?php
require_once dirname(__FILE__) . '/IRenderableDataObject.php';

interface IRenderableDataTree extends IRenderableDataObject {
	

	function getLevel();
	
}