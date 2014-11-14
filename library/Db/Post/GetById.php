<?php

namespace Db\Post;

use Core\Query;

class GetById extends Query
{

	protected $id;

	protected function build()
	{
		$query = '
			SELECT
				id,
				parent_post_id,
				user_id,
				visibility,
				content,
				image_file_id,
				created,
				modified
			FROM
				posts
			WHERE
				id = ?';

		$this->addBind($this->id);

		return $query;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

}