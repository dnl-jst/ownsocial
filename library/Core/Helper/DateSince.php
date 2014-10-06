<?php

class Core_Helper_DateSince
{

	public static function format($timespam)
	{
		$now = time();
		$difference = $now - $timespam;

		if ($difference < 60) {
			return 'vor wenigen Sekunden';
		} else if ($difference < 300) {
			return 'vor wenigen Minuten';
		} else if ($difference < 3600) {
			return 'vor ' . floor($difference / 60) . ' Minuten';
		} else if ($difference < 86400) {
			return 'vor ' . floor($difference / 60 / 60) . ' Stunden';
		} else {
			return 'vor ' . floor($difference / 60 / 60 / 24) . ' Tagen';
		}
	}

}