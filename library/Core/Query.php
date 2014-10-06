<?php

abstract class Core_Query
{
	/**
	 * @var Zend_Db_Adapter_Pdo_Mysql
	 */
	protected static $oDb;

	/**
	 * @var array
	 */
	protected $aBinds = array();

	public static function configureDb(Zend_Db_Adapter_Pdo_Mysql $oDb)
	{
		self::$oDb = $oDb;
	}

	abstract protected function build();

	public function addBind($mBind)
	{
		if (is_object($mBind) && $mBind instanceof Zend_Date)
		{
			/** @var $mBind Zend_Date */
			$mBind = $mBind->get('yyyy-MM-dd HH:mm:ss');
		}

		$this->aBinds[] = $mBind;
	}

	public function getBinds($bClear = false)
	{
		$aBinds = $this->aBinds;

		if ($bClear)
		{
			$this->clearBinds();
		}

		return $aBinds;
	}

	public function clearBinds()
	{
		$this->aBinds = array();
	}

	public function query()
	{
		return self::$oDb->query($this->build(), $this->getBinds(true));
	}

	public function fetchRow()
	{
		$mResult = self::$oDb->fetchRow($this->build(), $this->getBinds(true));

		if ($mResult === false)
		{
			throw new Core_Query_NoResultException();
		}

		return $mResult;
	}

	public function fetchCol()
	{
		$mResult = self::$oDb->fetchCol($this->build(), $this->getBinds(true));

		if ($mResult === false)
		{
			throw new Core_Query_NoResultException();
		}

		return $mResult;
	}

	public function fetchAll()
	{
		$mResult = self::$oDb->fetchAll($this->build(), $this->getBinds(true));

		if ($mResult === false)
		{
			throw new Core_Query_NoResultException();
		}

		return $mResult;
	}

	public function fetchOne()
	{
		$mResult = self::$oDb->fetchOne($this->build(), $this->getBinds(true));

		if ($mResult === false)
		{
			throw new Core_Query_NoResultException();
		}

		return $mResult;
	}

	public function fetchAssoc()
	{
		$mResult = self::$oDb->fetchAssoc($this->build(), $this->getBinds(true));

		if ($mResult === false)
		{
			throw new Core_Query_NoResultException();
		}

		return $mResult;
	}

	public function fetchPairs()
	{
		$mResult = self::$oDb->fetchPairs($this->build(), $this->getBinds(true));

		if ($mResult === false)
		{
			throw new Core_Query_NoResultException();
		}

		return $mResult;
	}

	public function insert()
	{
		self::$oDb->query($this->build(), $this->getBinds(true));

		return $this->lastInsertId();
	}

	public function lastInsertId()
	{
		return self::$oDb->lastInsertId();
	}

}