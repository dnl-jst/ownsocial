<?php

namespace Service;

use Core\Service;
use Db\Feed\GetByUserId;
use Db\Feed\GetUpdates;
use Db\Feed\GetByPostId;
use Db\Feed\GetByGroupId;
use Model\Feed as FeedModel;

class Feed extends Service
{

	/**
	 * @param $parentPostId
	 * @param $groupId
	 * @return FeedModel[]
	 * @throws \Core\Query\NoResultException
	 */
	public static function getGroupFeed($groupId, $parentPostId, $userId)
	{
		$query = new GetByGroupId();
		$query->setGroupId($groupId);
		$query->setUserId($userId);
		$query->setParentPostId($parentPostId);

		$model = new FeedModel();
		$aPosts = self::fillCollection($model, $query->fetchAll());

		return $aPosts;
	}

	/**
	 * @param $parentPostId
	 * @param $userId
	 * @return FeedModel[]
	 * @throws \Core\Query\NoResultException
	 */
	public static function getUserFeed($parentPostId, $userId)
	{
		$query = new GetByUserId();
		$query->setParentPostId($parentPostId);
		$query->setUserId($userId);

		$model = new FeedModel();
		$aPosts = self::fillCollection($model, $query->fetchAll());

		return $aPosts;
	}

	/**
	 * @param $lastUpdate
	 * @param $userId
	 * @param $posts
	 * @return FeedModel[]
	 * @throws \Core\Query\NoResultException
	 */
	public static function getUserFeedUpdates($lastUpdate, $userId, $posts)
	{
		$query = new GetUpdates();
		$query->setUserId($userId);
		$query->setPosts($posts);
		$query->setLastUpdate($lastUpdate);

		$model = new FeedModel();
		$aPosts = self::fillCollection($model, $query->fetchAll());

		return $aPosts;
	}

	/**
	 * @param $userId
	 * @param $postId
	 * @return FeedModel
	 * @throws \Core\Query\NoResultException
	 */
	public static function getUserFeedPost($userId, $postId)
	{
		$query = new GetByPostId();
		$query->setUserId($userId);
		$query->setPostId($postId);

		return self::fillModel(new FeedModel(), $query->fetchRow());
	}

}