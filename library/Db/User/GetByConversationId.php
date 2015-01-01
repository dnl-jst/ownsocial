<?php

namespace Db\User;

use Core\Query;

class GetByConversationId extends Query
{

	protected $conversationId;

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
				u.language,
				u.first_name,
				u.last_name,
				u.department,
				IFNULL(u.portrait_file_id, cnfg.value) AS portrait_file_id,
				u.created
			FROM
				conversation_users cu
			JOIN users u ON u.id = cu.user_id
			JOIN configs cnfg ON cnfg.key = \'default_portrait_id\'
			WHERE
				cu.conversation_id = ?';

		$this->addBind($this->conversationId);

		return $query;
	}

	/**
	 * @param mixed $conversationId
	 */
	public function setConversationId($conversationId)
	{
		$this->conversationId = $conversationId;
	}

}