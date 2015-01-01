<?php

namespace Service;

use Core\Service;
use Model\File as FileModel;
use Db\File\GetById;
use Db\File\Store;

class File extends Service
{

	/**
	 * @param $id
	 * @return FileModel
	 * @throws \Core\Query\NoResultException
	 */
	public static function getById($id)
	{
		$query = new GetById();
		$query->setId($id);

		return self::fillModel(new FileModel(), $query->fetchRow());
	}

	public static function store(FileModel $file)
	{
		$query = new Store();
		$query->setId($file->getId());
		$query->setUserId($file->getUserId());
		$query->setGroupId($file->getGroupId());
		$query->setContent($file->getContent());
		$query->setName($file->getName());
		$query->setType($file->getType());
		$query->setCreated($file->getCreated());

		if ($file->getId()) {
			$query->query();
			return $file->getId();
		} else {
			return $query->insert();
		}
	}

}