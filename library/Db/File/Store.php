<?php

class Db_File_Store extends Core_Query
{

	/** @var null|integer */
	protected $id;

	/** @var string */
	protected $content;

	/** @var string */
	protected $type;

	/** @var Zend_Date */
	protected $created;

	protected function build()
	{
		$sQuery = '
			INSERT INTO
				files
				(
					id,
					content,
					type,
					created
				)
			VALUES
				(
					?,
					?,
					?,
					?
				)
			ON DUPLICATE KEY UPDATE
				content = VALUES(content),
				type = VALUES(type)';

		$this->addBind($this->id);
		$this->addBind($this->content);
		$this->addBind($this->type);
		$this->addBind($this->created);

		return $sQuery;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @param string $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * @param Zend_Date $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

}