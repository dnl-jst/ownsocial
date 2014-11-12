<?php

class Core_Helper_DateSince
{

	public static function format($timespam)
	{
		$now = time();
		$difference = $now - $timespam;

		if ($difference < 60) {
			return 'few seconds ago';
		} else if ($difference < 300) {
			return 'few minutes ago';
		} else if ($difference < 3600) {
			return floor($difference / 60) . ' minutes ago';
		} else if ($difference < 86400) {
			return floor($difference / 60 / 60) . ' hours ago';
		} else {
			return floor($difference / 60 / 60 / 24) . ' days ago';
		}
	}

}