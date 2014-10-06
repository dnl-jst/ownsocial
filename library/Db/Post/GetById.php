<?php

class Db_Post_GetById extends Core_Query
{

	protected $id;

	protected function build()
	{
		$sQuery = '
			SELECT
				id,
				parent_post_id,
				user_id,
				visibility,
				content,
				created,
				modified
			FROM
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