<?php

namespace Service;

use Core\Service;
use Model\Post as PostModel;
use Db\Post\Store;
use Db\Post\GetById;
use Db\Post\Delete;

class Post extends Service
{

	/**
	 * @param PostModel $post
	 * @return integer
	 */
	public static function store(PostModel $post)
	{
		$query = new Store();
		$query->setId($post->getId());
		$query->setRootPostId($post->getRootPostId());
		$query->setParentPostId($post->getParentPostId());
		$query->setUserId($post->getUserId());
		$query->setVisibility($post->getVisibility());
		$query->setContent($post->getContent());
		$query->setImageFileId($post->getImageFileId());
		$query->setCreated($post->getCreated());
		$query->setModified($post->getModified());

		if ($post->getId()) {
			$query->query();
			return $post->getId();
		} else {
			return $query->insert();
		}
	}

	/**
	 * @param $id
	 * @return PostModel
	 * @throws \Core\Query\NoResultException
	 */
	public static function getById($id)
	{
		$query = new GetById();
		$query->setId($id);

		return self::fillModel(new PostModel(), $query->fetchRow());
	}

	/**
	 * @param integer $id
	 * @return void
	 */
	public static function delete($id)
	{
		$query = new Delete();
		$query->setId($id);
		$query->query();
	}

}