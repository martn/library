<?php

require_once dirname(__FILE__) . '/../TableBase/StructureRendererTable/StructureRendererTable.php';


class ListTable extends StructureRendererTable {


	/**
	 * @desc adds a row
	 */
/*	public function addRow()
	{
		if($this->getMode() !== MODE_MANUAL) throw new InvalidModeException();
		
		$this->addObject(new ArrayList(), 'rows');
	}*/




	/**
	 * @desc adds new cell with data
	 */
/*	public function addData($data)
	{
		$this->getCurrent('rows')->append($data);
		$this->updateCols($this->getCurrent('rows'));
	}*/
	
	
	
	/**
	 * updates global columns count
	 * @param unknown_type $count
	 * @return unknown_type
	 */
/*	private function updateCols($count)
	{
		if($this->columns_count < $count) $this->columns_count = $coung;
	}*/




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




	

	 
	/* (non-PHPdoc)
	 * @see scripts/app/controls/Tables/TableBase/TableBase#getCellLayout()
	 */
}


