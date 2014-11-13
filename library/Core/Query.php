<?php

abstract class Core_Query
{
	/**
	 * @var Zend\Db\Adapter\Adapter
	 */
	protected static $db;

	/**
	 * @var array
	 */
	protected $binds = array();

	public static function configureDb(Zend\Db\Adapter\Adapter $db)
	{
		self::$db = $db;
	}

	abstract protected function build();

	public function addBind($bind)
	{
		$this->binds[] = $bind;
	}

	public function getBinds($clear = false)
	{
		$binds = $this->binds;

		if ($clear) {
			$this->clearBinds();
		}

		return $binds;
	}

	public function clearBinds()
	{
		$this->binds = array();
	}

	public function query()
	{
		$statement = self::$db->createStatement($this->build());

		return $statement->execute($this->getBinds(true));
	}

	public function fetchRow()
	{
		$result = $this->query();

		if ($result === false)
		{
			throw new Core_Query_NoResultException();
		}

		return $result->current();
	}

	public function fetchAll()
	{
		$result = $this->query();

		if ($result === false) {
			throw new Core_Query_NoResultException();
		}

		return $result;
	}

	public function fetchOne()
	{
		$result = $this->query();

		if ($result === false) {
			throw new Core_Query_NoResultException();
		}

		$row = $result->current();

		return reset($row);
	}

	public function fetchAssoc()
	{
		$result = $this->query();

		if ($result === false) {
			throw new Core_Query_NoResultException();
		}

		$return = array();

		foreach ($result as $row) {
			$return[$row['key']] = $row;
		}

		return $return;
	}

	public function insert()
	{
		$this->query();

		return $this->lastInsertId();
	}

	public function lastInsertId()
	{
		return self::$db->getDriver()->getLastGeneratedValue();
	}

}