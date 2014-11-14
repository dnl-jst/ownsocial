<?php

namespace Core;

use Zend\Db\Adapter\Driver\Pdo\Result;

abstract class Service
{

	protected static function fillModel($model, array $data)
	{
		foreach ($data as $name => $value)
		{
			$nameParts = explode('_', $name);
			$nameParts = array_map('ucfirst', $nameParts);
			$name = 'set' . implode($nameParts);

			if (method_exists($model, $name))
			{
				$model->$name($value);
			}
		}

		return $model;
	}

	protected static function fillCollection($model, Result $elements)
	{
		$collection = array();

		foreach ($elements as $element)
		{
			$collection[] = self::fillModel(clone $model, $element);
		}

		return $collection;
	}

}