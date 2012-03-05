<?php

require_once COMPONENTS_DIR . '/Base/BaseControl.php';


class MapControl extends BaseControl {

	const LAYOUT_MAINMENU = 'mainmenu';
	 
	protected $template;

	protected $map;

	protected $data;

	protected $layout;
	 
	 
	/**
	 * @desc constructor
	 */
	public function __construct() {
		parent::__construct();

		$this->setTemplate(dirname(__FILE__) . '/template.phtml');
	}



	/**
	 * @desc sets a template
	 */
	public function setTemplate($file)
	{
		$this->template = $file;
	}




	/**
	 * @desc sets internal data
	 * @param MapModelTree $map
	 * @return MapModelTree
	 */
	public function setMap(Tree $map)
	{
		return $this->map = $map;
	}




	/**
	 * sets data for rendering
	 */
	public function setData($data)
	{
		$this->data = $data;
	}



	/**
	 * @desc returns current map
	 * @return MapModelTree
	 */
	public function getMap()
	{
		return $this->map;
	}




	/**
	 * @desc prepares template for rendering with data
	 * @param Template $template
	 */
	protected function prepareTemplate()
	{
		$template = $this->createTemplate();

		$template->setFile($this->template);
		$template->data = $this->getMap();
	}



	/**
	 * @desc renders map
	 */
	public function render()
	{
		//echo $this->__toString();

		$template = $this->prepareTemplate();
		$template->render();
	}
}

