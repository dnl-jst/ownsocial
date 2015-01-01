<?php

namespace Service\Conversation;

use Core\Query\NoResultException;
use Core\Service;
use Db\Conversation\Post\GetLastByConversationId;
use Db\Conversation\Post\GetUnreadCount;
use Db\Conversation\Post\Store;
use Db\Conversation\Post\StoreSeen;
use Model\Conversation\Post as ConversationPostModel;
use Model\Conversation\Post\Seen as ConversationPostSeenModel;
use Service\User;

class Post extends Service
{

	/**
	 * @param int $conversationId
	 * @param int $userId
	 * @param int $offset
	 * @return ConversationPostModel[]
	 * @throws \Core\Query\NoResultException
	 */
	public static function getLastByConversationId($conversationId, $userId, $offset = 0, $limit = 10)
	{
		$query = new GetLastByConversationId();
		$query->setConversationId($conversationId);
		$query->setUserId($userId);
		$query->setOffset($offset);
		$query->setLimit($limit);

		return self::fillCollection(new ConversationPostModel(), $query->fetchAll());
	}

	/**
	 * @param ConversationPostModel $post
	 * @return int
	 */
	public static function store(ConversationPostModel $post)
	{
		$query = new Store();
		$query->setId($post->getId());
		$query->setConversationId($post->getConversationId());
		$query->setUserId($post->getUserId());
		$query->setMessage($post->getMessage());
		$query->setCreated($post->getCreated());

		if ($post->getId()) {
			$query->query();
		} else {
			$post->setId($query->insert());
		}

		return $post->getId();
	}

	/**
	 * @return int
	 */
	public static function getUnreadCount()
	{
		$query = new GetUnreadCount();
		$query->setUserId(User::getCurrent()->getId());

		try {
			return (int)$query->fetchOne();
		} catch (NoResultException $e) {
			return 0;
		}
	}

	/**
	 * @param ConversationPostSeenModel $postSeen
	 */
	public static function storeSeen(ConversationPostSeenModel $postSeen)
	{
		$query = new StoreSeen();
		$query->setPostId($postSeen->getPostId());
		$query->setUserId($postSeen->getUserId());
		$query->setCreated($postSeen->getCreated());
		$query->query();
	}

}