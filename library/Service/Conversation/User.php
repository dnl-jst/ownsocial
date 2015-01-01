<?php

namespace Service\Conversation;

use Core\Service;
use Db\Conversation\User\GetByConversationIdAndUserId;
use Db\Conversation\User\Store;
use Model\Conversation\User as ConversationUserModel;

class User extends Service
{

	/**
	 * @param $conversationId
	 * @param $userId
	 * @return ConversationUserModel
	 * @throws \Core\Query\NoResultException
	 */
	public static function getByConversationIdAndUserId($conversationId, $userId)
	{
		$query = new GetByConversationIdAndUserId();
		$query->setConversationId($conversationId);
		$query->setUserId($userId);

		return self::fillModel(new ConversationUserModel(), $query->fetchRow());
	}

	public static function store(ConversationUserModel $conversationUser)
	{
		$query = new Store();
		$query->setId($conversationUser->getId());
		$query->setConversationId($conversationUser->getConversationId());
		$query->setUserId($conversationUser->getUserId());
		$query->setCreated($conversationUser->getCreated());
		$query->setCreatedBy($conversationUser->getCreatedBy());
		$query->query();
	}

}