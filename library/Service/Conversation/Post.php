<?php

namespace Service\Conversation;

use Core\Service;
use Db\Conversation\Post\GetLastByConversationId;
use Model\Conversation\Post as ConversationPostModel;

class Post extends Service
{

	public static function getLastByConversationId($conversationId, $offset = 0)
	{
		$query = new GetLastByConversationId();
		$query->setConversationId($conversationId);
		$query->setOffset($offset);

		return self::fillCollection(new ConversationPostModel(), $query->fetchAll());
	}

}