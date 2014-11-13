<?php

class Service_Post extends Core_Service
{

	public static function store(Model_Post $post)
	{
		$query = new Db_Post_Store();
		$query->setId($post->getId());
		$query->setParentPostId($post->getParentPostId());
		$query->setUserId($post->getUserId());
		$query->setVisibility($post->getVisibility());
		$query->setContent($post->getContent());
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
	 * @return Model_Post
	 * @throws Core_Query_NoResultException
	 */
	public static function getById($id)
	{
		$query = new Db_Post_GetById();
		$query->setId($id);

		return self::fillModel(new Model_Post(), $query->fetchRow());
	}

	public static function delete($id)
	{
		$query = new Db_Post_Delete();
		$query->setId($id);
		$query->query();
	}

}