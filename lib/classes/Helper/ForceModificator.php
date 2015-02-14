<?php
namespace Helper;

/**
 * Description of ForceModificator
 *
 * @author Neithan
 */
class ForceModificator
{
	/**
	 * Takes a force modificator string and parses it into an array
	 *
	 * @param string $forceModificator
	 *
	 * @return array
	 */
	public static function getForceModificatorArray($forceModificator)
	{
		preg_match_all('/([+-]?\d) ?\/ ?([+-]?\d) ?(?:\|\||or|oder)?/', $forceModificator, $matches, PREG_SET_ORDER);
		$forceModificators = array();

		foreach ($matches as $match)
		{
			$forceModificators[] = array(
				'attack' => intval($match[1]),
				'parade' => intval($match[2]),
			);
		}

		return $forceModificators;
	}

	/**
	 * Takes the attack and parade force modifiers and returns them as an array
	 *
	 * @param type $attack
	 * @param type $parade
	 *
	 * @return array
	 */
	public static function toForceModificatorArray($attack, $parade)
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
}
