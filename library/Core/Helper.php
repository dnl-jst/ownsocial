<?php

namespace Core;

abstract class Helper
{

	protected static $translator = null;

	protected static function translate($key, $replacements = array())
	{
		if (self::$translator === null) {
			self::$translator = new Translator(APPLICATION_ROOT . '/languages/');
		}

		return self::$translator->translate($key, $replacements);
	}

}