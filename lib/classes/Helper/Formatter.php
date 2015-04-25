<?php
namespace Helper;

/**
 * Description of Formatter
 *
 * @author Neithan
 */
class Formatter
{
	public static function time($time, $withSeconds = false)
	{
		$translator = \SmartWork\Translator::getInstance();

		if ($withSeconds)
		{
			return date($translator->getTranslation('timeFormat'), $time);
		}
		else
		{
			return date($translator->getTranslation('timeFormatShort'), $time);
		}
	}

	public static function days($time)
	{
		return $time / (23 * 3600);
	}
}
