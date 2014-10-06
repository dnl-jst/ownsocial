<?php

abstract class Core_Model
{

	public function toArray()
	{
		return get_object_vars($this);
	}

}