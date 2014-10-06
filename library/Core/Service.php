<?php
/**
 *
 *
 * @author djost
 * @since 08.02.2013
 * @category
 * @package
 * @subpackage
 */
abstract class Core_Service
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

	protected static function fillCollection($model, array $elements)
	{
		$collection = array();

		foreach ($elements as $element)
		{
			$collection[] = self::fillModel(clone $model, $element);
		}

		return $collection;
	}

}