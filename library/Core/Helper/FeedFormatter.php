<?php

namespace Core\Helper;

class FeedFormatter
{

	public static function format($content)
	{
		# strip tags
		$content = strip_tags($content);

		# replace links
		$content = preg_replace('~(http|https)\:\/\/[^\s]+~', '<a href="$0" target="_blank">$0</a>', $content);

		# newlines to br
		$content = nl2br($content);

		return $content;
	}

}