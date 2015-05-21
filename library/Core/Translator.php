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

		$dir = dir($languageDir);

		while (($entry = $dir->read()) !== false) {
			if ($entry[0] !== '.' && substr($entry, -4) === '.php') {
				$this->translations[substr($entry, 0, 2)] = require($languageDir . $entry);
			}
		}
	}

	public function translate($key, $replacements = array(), $language = null)
	{
		if ($language === null) {
			$language = $this->getCurrentLanguage();
		}

		if (!isset($this->translations[$language][$key])) {
			return '[[' . $key . ']]';
		}

		$translation = $this->translations[$language][$key];

		foreach ($replacements as $key => $value) {
			$translation = str_replace('%%' . $key . '%%', $value, $translation);
		}

		return $translation;
	}

	public function _($key)
	{
		return $this->translate($key);
	}

	protected function getCurrentLanguage()
	{
		$language = 'en';

		if ($defaultLanguage = Config::getByKey('default_language')) {
			$language = $defaultLanguage;
		}

		$user = User::getCurrent();

		if ($user && $user->getLanguage()) {
			$language = $user->getLanguage();
		}

		if (!isset($this->translations[$language])) {
			$language = 'en';
		}

		return $language;
	}

}