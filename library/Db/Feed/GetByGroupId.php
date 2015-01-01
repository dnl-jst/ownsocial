<?php

namespace Db\Feed;

use Core\Query;

class GetByGroupId extends Query
{

	protected $parentPostId;
	protected $userId;
	protected $groupId;

	protected function build()
	{
		$query = '
			SELECT
				p.id,
				p.root_post_id,
				p.parent_post_id,
				p.user_id,
				p.group_id,
				p.visibility,
				p.content,
				p.image_file_id,
				p.attachment_file_id,
				p.created,
				p.modified,
				u.first_name,
				u.last_name,
				IFNULL(u.portrait_file_id, cnfg.value) AS portrait_file_id,
				IF(IFNULL(ml.user_id, 0) = 0, 0, 1) AS liked,
				COUNT(al.user_id) AS likes,
				COUNT(sp.id) AS comments
			FROM
				posts p
			JOIN users u ON u.id = p.user_id
			JOIN configs cnfg ON cnfg.key = \'default_portrait_id\'
			LEFT JOIN posts sp ON sp.parent_post_id = p.id
			LEFT JOIN likes ml ON ml.post_id = p.id AND ml.user_id = ?
			LEFT JOIN likes al ON al.post_id = p.id
			WHERE
				p.visibility = \'group\'
			AND	p.group_id = ?';

		$this->addBind($this->userId);
		$this->addBind($this->groupId);

		if ($this->parentPostId) {
			$query .= '
				AND p.parent_post_id = ?';

			$this->addBind($this->parentPostId);
		} else {
			$query .= '
				AND
					p.parent_post_id IS NULL';
		}

		$query .= '
			GROUP BY
				p.id
			ORDER BY
				p.created DESC
			LIMIT 10';

		return $query;
	}

	/**
	 * @param mixed $parentPostId
	 */
	public function setParentPostId($parentPostId)
	{
		$this->parentPostId = $parentPostId;
	}

	/**
	 * @param mixed $groupId
	 */
	public function setGroupId($groupId)
	{
		$this->groupId = $groupId;
	}

	/**
	 * @param mixed $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

}