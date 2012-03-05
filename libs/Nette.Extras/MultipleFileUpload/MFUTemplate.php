<?php

class MFUTemplate extends NTemplate {

	function  __construct() {
		parent::__construct();
		$this->onPrepareFilters[] = callback($this, "registerFilters");
	}

	function registerFilters() {
		$this->registerFilter(new NLatteFilter());
	}

}