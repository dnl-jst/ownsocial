<?php

namespace Service;

use Core\Service;
use Model\Like as LikeModel;
use Db\Like\Store;
use Db\Like\Delete;

class Like extends Service
{
	public static function store(LikeModel $like)
	{
		$query = new Store();
		$query->setUserId($like->getUserId());
		$query->setPostId($like->getPostId());
		$query->setCreated($like->getCreated());
		$query->query();
	}

	public static function delete(LikeModel $like)
	{
		$query = new Delete();
		$query->setUserId($like->getUserId());
		$query->setPostId($like->getPostId());
		$query->query();
	}
}
