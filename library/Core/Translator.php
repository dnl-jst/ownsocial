<?php

namespace Core;

use Service\Config;
use Service\User;

class Translator
{

	protected $translations = array();

	public function __construct($languageDir)
	{
		$languageDir = rtrim($languageDir, '/') . '/';

		$language = 'en';

		if ($defaultLanguage = Config::getByKey('default_language')) {
			$language = $defaultLanguage;
		}

		$user = User::getCurrent();

		if ($user && $user->getLanguage()) {
			$language = $user->getLanguage();
		}

		if (!is_file($languageDir . $language . '.php')) {
			$language = 'en';
		}

		$this->translations = require($languageDir . $language . '.php');
	}

	public function translate($key, $replacements = array())
	{
		if (!isset($this->translations[$key])) {
			return '[[' . $key . ']]';
		}

		$translation = $this->translations[$key];

		foreach ($replacements as $key => $value) {
			$translation = str_replace('%%' . $key . '%%', $value, $translation);
		}

		return $translation;
	}

	public function _($key)
	{
		return $this->translate($key);
	}

}