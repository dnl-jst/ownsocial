<?php

class Db_Feed_GetByPostId extends Core_Query
{

	protected $userId;
	protected $postId;

	protected function build()
	{
		$sQuery = '
			SELECT
				p.id,
				p.parent_post_id,
				p.user_id,
				p.group_id,
				p.visibility,
				p.content,
				p.created,
				p.modified,
				u.first_name,
				u.last_name,
				IFNULL(u.portrait_file_id, c.value) AS portrait_file_id,
				IF(IFNULL(ml.user_id, 0) = 0, 0, 1) AS liked,
				COUNT(al.user_id) AS likes,
				COUNT(c.id) AS comments
			FROM
				posts p
			JOIN users u ON u.id = p.user_id
			JOIN configs c ON c.key = \'default_portrait_id\'
			LEFT JOIN posts c ON c.parent_post_id = p.id
			LEFT JOIN likes ml ON ml.post_id = p.id AND ml.user_id = ?
			LEFT JOIN likes al ON al.post_id = p.id
			WHERE
				p.id = ?
			GROUP BY
				p.id
			ORDER BY
				p.created DESC
			LIMIT 10';

		$this->addBind($this->userId);
		$this->addBind($this->postId);

		return $sQuery;
	}

	/**
	 * @param mixed $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	/**
	 * @param mixed $postId
	 */
	public function setPostId($postId)
	{
		$this->postId = $postId;
	}
}