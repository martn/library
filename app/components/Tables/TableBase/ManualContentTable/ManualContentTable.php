<?php

require_once dirname(__FILE__) . '/../TableBase.php';


abstract class ManualContentTable extends TableBase {

	private $column_count = 0;

	/**
	 * @desc adds a row
	 */
	public function addRow()
	{
		$this->addObject(new ArrayList(), 'rows');
	}


	/**
	 * adds head column
	 * @param unknown_type $data
	 */
	public function addHead($data)
	{
		$this->addObject($data, 'head');
		$this->updateColumnCount($this->countObjects('head'));
	}


	/**
	 * @desc adds new cell with data
	 * @param mixed $data
	 */
	public function addData($data)
	{
		$this->getCurrent('rows')->append($data);
		$this->updateColumnCount($this->getCurrent('rows')->count());
	}



	/**
	 * updates global columns count
	 * @param integer $count
	 * @return void
	 */
	private function updateColumnCount($count)
	{
		if($this->column_count < $count) $this->column_count = $count;
	}



	/**
	 * returns column count
	 * @return integer
	 */
	protected function getColumnCount()
	{
		return $this->column_count;
	}




	function renderBody()
	{
		$template = $this->createTemplate();
		$template->setFile(dirname(__FILE__).'/row.phtml');
		 
		foreach($this->getObjects('rows') as $row)
		{
			$template->data = $row;
			$template->overhead = $this->getColumnCount()-$row->count();
			$template->render();
		}
	}
	 



	function renderHead()
	{
		if($this->countObjects('head') > 0)
		{
			$template = $this->createTemplate();

			$template->setFile(dirname(__FILE__).'/head.phtml');

			$template->heads = $this->getObjects('head');
			$template->overhead = $this->getColumnCount()-$this->countObjects('head');

			$template->render();
		}
	}




	/**
	 * @desc updates cols in all rows to same count
	 */
	/*protected function narrowCols()
	 {
		if($this->head->count() > 0) {

		while($this->head->count() < $this->cols) {
		$this->addHead('');
		}
		}

		if(!empty($this->data)) {
		foreach($this->data as $data) {
		while($data->count() < $this->cols) $data->append('');
		}
		}
		}*/

}


