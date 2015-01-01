<?php

namespace Service;

use Core\Service;
use Db\Conversation\GetById;
use Db\Conversation\GetByUserId;
use Db\Conversation\Store;
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

	/**
	 * @param $id
	 * @return ConversationModel
	 * @throws \Core\Query\NoResultException
	 */
	public static function getById($id)
	{
		$query = new GetById();
		$query->setId($id);

		return self::fillModel(new ConversationModel(), $query->fetchRow());
	}

	/**
	 * @param ConversationModel $conversation
	 * @return int
	 */
	public static function store(ConversationModel $conversation)
	{
		$query = new Store();
		$query->setId($conversation->getId());
		$query->setTitle($conversation->getTitle());
		$query->setCreated($conversation->getCreated());
		$query->setCreatedBy($conversation->getCreatedBy());
		$query->setLastUpdate($conversation->getLastUpdate());

		if ($conversation->getId()) {
			$query->query();
			return $conversation->getId();
		} else {
			$conversation->setId($query->insert());
			return $conversation->getId();
		}
	}

}