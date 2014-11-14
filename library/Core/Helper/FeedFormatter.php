<?php

namespace Core\Helper;

class FeedFormatter
{

	public static function format($content)
	{
		$content = strip_tags($content);
		$content = nl2br($content);

		return $content;
	}

}