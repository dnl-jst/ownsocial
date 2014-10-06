<?php

class Service_Feed extends Core_Service
{

	/**
	 * @param $parentPostId
	 * @param $userId
	 * @return Model_Feed[]
	 * @throws Core_Query_NoResultException
	 */
	public static function getUserFeed($parentPostId, $userId)
	{
		$query = new Db_Feed_GetByUserId();
		$query->setParentPostId($parentPostId);
		$query->setUserId($userId);

		$model = new Model_Feed();
		$aPosts = self::fillCollection($model, $query->fetchAll());

		return $aPosts;
	}

	/**
	 * @param $lastUpdate
	 * @param $userId
	 * @param $posts
	 * @return Model_Feed[]
	 * @throws Core_Query_NoResultException
	 */
	public static function getUserFeedUpdates($lastUpdate, $userId, $posts)
	{
		$query = new Db_Feed_GetUpdates();
		$query->setUserId($userId);
		$query->setPosts($posts);
		$query->setLastUpdate($lastUpdate);

		$model = new Model_Feed();
		$aPosts = self::fillCollection($model, $query->fetchAll());

		return $aPosts;
	}

	/**
	 * @param $userId
	 * @param $postId
	 * @return Model_Feed
	 * @throws Core_Query_NoResultException
	 */
	public static function getUserFeedPost($userId, $postId)
	{
		$query = new Db_Feed_GetByPostId();
		$query->setUserId($userId);
		$query->setPostId($postId);

		return self::fillModel(new Model_Feed(), $query->fetchRow());
	}

}