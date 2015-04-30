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
 * Helper class for transforming the hit points array.
 *
 * @package Helper
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class HitPoints
{
	/**
	 * Transform the hit points array into a string of the following format:
	 * {diceCount}{diceType}+/-{additional}
	 * Also adds the stamina damage flag.
	 *
	 * Examples:
	 * 2W6+2
	 * 1W20+0
	 * 1W6+1 (A)
	 *
	 * @param array $hitPointsArray
	 *
	 * @return string
	 */
	public static function getHitPointsString($hitPointsArray)
	{
		$translator = \SmartWork\Translator::getInstance();
		$hitPointsString = $hitPointsArray['hitPointsDice'];
		$hitPointsString .=$translator->gt($hitPointsArray['hitPointsDiceType']);
		$hitPointsString .= sprintf('%+d', $hitPointsArray['hitPoints']);

		if ($hitPointsArray['damageType'] == 'stamina')
		{
			$hitPointsString .= ' ' . $translator->gt('(S)');
		}

		return $hitPointsString;
	}
}
