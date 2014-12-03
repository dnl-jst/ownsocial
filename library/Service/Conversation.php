<?php

namespace Service;

use Core\Service;
use Db\Conversation\GetByUserId;
use Model\Conversation as ConversationModel;

class Conversation extends Service
{

	/**
	 * @param $userId
	 * @return ConversationModel[]
	 * @throws \Core\Query\NoResultException
	 */
	public static function getByUserId($userId)
	{
		$query = new GetByUserId();
		$query->setUserId($userId);

		$conversations = self::fillCollection(new ConversationModel(), $query->fetchAll());

		return $conversations;
	}

}