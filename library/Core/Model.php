<?php

namespace Core;

abstract class Model
{

	public function toArray()
	{
		return get_object_vars($this);
	}

}