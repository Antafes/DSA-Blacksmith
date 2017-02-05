<?php
/**
 * Part of the dsa blacksmith
 *
 * @package Helper
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
namespace Helper;

/**
 * Helper class for parsing the weaponmodificator.
 *
 * @package Helper
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class WeaponModificator
{
    /**
     * Takes a weapon modificator string and parses it into an array.
     * String: 1/-1
     * Array:
     * array(
     *     array(
     *         'attack' => 1,
     *         'parade' => -1,
     *     )
     * )
     *
     * @param string $weaponModificator The weapon modificator as a string
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
     * @param integer $attack
     * @param integer $parade
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
        if (!isset($weaponModificator['attack']) && !isset($weaponModificator['parade']))
        {
            return '0 / 0';
        }

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
