<?php
/**
 * Created by PhpStorm.
 * User: danieljost
 * Date: 02.11.14
 * Time: 19:09
 */

class Db_User_Search extends Core_Query
{

	protected $search;

	protected function build()
	{
		$query = '
			SELECT
				u.id,
				u.email,
				u.password,
				u.first_name,
				u.last_name,
				IFNULL(u.portrait_file_id, cnfg.value) AS portrait_file_id,
				u.created
			FROM
				users u
			JOIN configs cnfg ON cnfg.key = \'default_portrait_id\'
			WHERE
				u.first_name LIKE ?
			OR 	u.last_name LIKE ?';

		$this->addBind($this->search . '%');
		$this->addBind($this->search . '%');

		return $query;
	}

	/**
	 * @param mixed $search
	 */
	public function setSearch($search)
	{
		$this->search = $search;
	}

}