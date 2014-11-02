<?php

class Service_Like extends Core_Service
{
	public static function store(Model_Like $like)
	{
		$query = new Db_Like_Store();
		$query->setUserId($like->getUserId());
		$query->setPostId($like->getPostId());
		$query->setCreated($like->getCreated());
		$query->query();
	}

	public static function delete(Model_Like $like)
	{
		$query = new Db_Like_Delete();
		$query->setUserId($like->getUserId());
		$query->setPostId($like->getPostId());
		$query->query();
	}
}
