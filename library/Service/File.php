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

}