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
		if ($withSeconds)
		{
			return date(\Translator::getInstance()->getTranslation('timeFormat'), $time);
		}
		else
		{
			return date(\Translator::getInstance()->getTranslation('timeFormatShort'), $time);
		}
	}

	public static function days($time)
	{
		return $time / (23 * 3600);
	}
}
