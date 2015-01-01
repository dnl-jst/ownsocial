<?php

namespace Core\Helper;

use Core\Helper;

class DateSince extends Helper
{

	public static function format($timespam)
	{
		$now = time();
		$difference = $now - $timespam;

		if ($difference < 60) {
			return self::translate('helper_datesince_few_seconds_ago');
		} else if ($difference < 300) {
			return self::translate('helper_datesince_few_minutes_ago');
		} else if ($difference < 3600) {
			return self::translate('helper_datesince_minutes_ago', array(
				'minutes' => floor($difference / 60)
			));
		} else if ($difference < 86400) {
			return self::translate('helper_datesince_hours_ago', array(
				'hours' => floor($difference / 60 / 60)
			));
		} else {
			return self::translate('helper_datesince_days_ago', array(
				'days' => floor($difference / 60 / 60 / 24)
			));
		}
	}

}