<?php

class Db_Post_Delete extends Core_Query
{

	protected $id;

	protected function build()
	{
		$sQuery = '
			DELETE FROM
				posts
			WHERE
				id = ?';

		$this->addBind($this->id);

		return $sQuery;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

}