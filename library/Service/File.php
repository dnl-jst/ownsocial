<?php

class Service_File extends Core_Service
{

	/**
	 * @param $id
	 * @return Model_File
	 * @throws Core_Query_NoResultException
	 */
	public static function getById($id)
	{
		$query = new Db_File_GetById();
		$query->setId($id);

		return self::fillModel(new Model_File(), $query->fetchRow());
	}

	public static function store(Model_File $file)
	{
		$query = new Db_File_Store();
		$query->setId($file->getId());
		$query->setContent($file->getContent());
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