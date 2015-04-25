<?php
/**
 * Part of the dsa blacksmith.
 *
 * @package Helper
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
namespace Helper;

/**
 * Helper class for formatting the time and days.
 *
 * @package Helper
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Formatter
{
	/**
	 * Format a timestamp according the time format in the translations.
	 *
	 * @param integer $time        The timestamp to format
	 * @param boolean $withSeconds Whether to add seconds to the formatted time or not
	 *
	 * @return string
	 */
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
}
