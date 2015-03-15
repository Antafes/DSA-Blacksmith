<?php
namespace Helper;

/**
 * Description of WeaponModificator
 *
 * @author Neithan
 */
class WeaponModificator
{
	/**
	 * Takes a weapon modificator string and parses it into an array
	 *
	 * @param string $weaponModificator
	 *
	 * @return array
	 */
	public static function getWeaponModificatorArray($weaponModificator)
	{
		preg_match_all('/([+-]?\d) ?\/ ?([+-]?\d) ?(?:\|\||or|oder)?/', $weaponModificator, $matches, PREG_SET_ORDER);
		$weaponModificators = array();

		foreach ($matches as $match)
		{
			$weaponModificators[] = array(
				'attack' => intval($match[1]),
				'parade' => intval($match[2]),
			);
		}

		return $weaponModificators;
	}

	/**
	 * Takes the attack and parade weapon modifiers and returns them as an array
	 *
	 * @param type $attack
	 * @param type $parade
	 *
	 * @return array
	 */
	public static function toWeaponModificatorArray($attack, $parade)
	{
		if (!$attack && !$parade)
			return array();

		return array(
			array(
				'attack' => $attack,
				'parade' => $parade,
			),
		);
	}

	/**
	 * Format a weapon modifier array into a string of the following format: [attack] / [parade]
	 * Examples:
	 * 0 / 0
	 * -1 / +1
	 *
	 * @param array $weaponModificator An array of the following format:
	 *                                 array(
	 *                                     'attack' => 0,
	 *                                     'parade' => 0,
	 *                                 )
	 *
	 * @return string
	 */
	public static function format($weaponModificator)
	{
		$modificatorString = '';

		if ($weaponModificator['attack'] > 0)
		{
			$modificatorString .= '+';
		}

		$modificatorString .= $weaponModificator['attack'].' / ';

		if ($weaponModificator['parade'] > 0)
		{
			$modificatorString .= '+';
		}

		$modificatorString .= $weaponModificator['parade'];

		return $modificatorString;
	}
}
