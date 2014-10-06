<?php

class Service_Config extends Core_Service
{

	public static function getAll()
	{
		$query = new Db_Config_GetAll();
		return $query->fetchAssoc();
	}

}