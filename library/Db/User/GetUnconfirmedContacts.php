<?php

namespace Db\User;

use Core\Query;

class GetUnconfirmedContacts extends Query
{

	protected $id;

	protected function build()
	{
		$query = '
			SELECT
				u.id,
				u.type,
				u.email,
				u.email_confirmed,
				u.email_confirmation_hash,
				u.account_confirmed,
				u.password,
				u.first_name,
				u.last_name,
				IFNULL(u.portrait_file_id, cnfg.value) AS portrait_file_id,
				u.created
			FROM
				users u
			JOIN	(
					SELECT
						u.id AS user_id,
						IF(r.user_id = u.id, r.user_id2, r.user_id) AS relation_id
					FROM
						users u
					LEFT JOIN relations r ON (r.user_id = u.id OR r.user_id2 = u.id) AND r.confirmed IS NOT NULL
				) uf ON uf.user_id = u.id
			JOIN	(
					SELECT
						u.id AS user_id,
						IF(r.user_id = u.id, r.user_id2, r.user_id) AS relation_id
					FROM
						users u
					LEFT JOIN relations r ON (r.user_id = u.id OR r.user_id2 = u.id) AND r.confirmed IS NOT NULL
				) mf ON mf.user_id = ?
			JOIN relations r ON r.user_id = u.id AND r.user_id2 = ? AND r.confirmed IS NULL
			JOIN configs cnfg ON cnfg.key = \'default_portrait_id\'
			GROUP BY
				u.id';

		$this->addBind($this->id);
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