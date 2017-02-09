<?php
/**
 * Part of the dsa blacksmith
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
namespace Listing;

/**
 * List class for blueprints.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Blueprints extends \SmartWork\Listing
{
    /**
     * Load all available blueprints for the logged in user.
     *
     * @return \self
     */
    public static function loadList($orderBy = 'name')
    {
        $sql = '
            SELECT `blueprintId`
            FROM blueprints
            WHERE userid = '.\sqlval($_SESSION['userId']).'
                AND !deleted
            ORDER BY '.sqlval($orderBy, false).'
        ';
        $blueprintIds = query($sql, true);
        $obj = new self();

        if (empty($blueprintIds))
        {
            return $obj;
        }

        $list = array();
        foreach ($blueprintIds as $blueprint)
        {
            $list[$blueprint['blueprintId']] = \Model\Blueprint::loadById($blueprint['blueprintId']);
        }

        $obj->setList($list);

        return $obj;
    }

    /**
     * Load all available blueprints for the logged in user.
     *
     * @return \self
     */
    public static function loadPublicList($orderBy = 'name')
    {
        $user = \User::getUserById($_SESSION['userId']);

        if ($user->getShowPublicBlueprints())
        {
            $sql = '
                SELECT `blueprintId`
                FROM blueprints
                WHERE `public` = 1
                    AND userid != '.\sqlval($_SESSION['userId']).'
                    AND !deleted
                ORDER BY '.sqlval($orderBy, false).'
            ';
            $blueprintIds = query($sql, true);
        }

        $obj = new self();

        if (empty($blueprintIds))
        {
            return $obj;
        }

        $list = array();
        foreach ($blueprintIds as $blueprint)
        {
            $list[$blueprint['blueprintId']] = \Model\Blueprint::loadById($blueprint['blueprintId']);
        }

        $obj->setList($list);

        return $obj;
    }

    /**
     * Get a single blueprint by its id.
     *
     * @param integer $id
     *
     * @return \Model\Blueprint
     */
    public function getById($id)
    {
        return $this->list[$id];
    }

    /**
     * Get an array of blueprints grouped by the item type.
     * Group keys may be on of:
     * - meleeWeapon
     * - rangedWeapon
     * - shield
     * - armor
     * - projectile
     *
     * @return array
     */
    public function getGroupedList()
    {
        $groupedBlueprints = array();

        /* @var $blueprint \Model\Blueprint */
        foreach ($this->list as $blueprint)
        {
            if (!isset($groupedBlueprints[$blueprint->getItemType()->getType()]))
            {
                $groupedBlueprints[$blueprint->getItemType()->getType()] = array();
            }

            $groupedBlueprints[$blueprint->getItemType()->getType()][] = $blueprint->getAsArray();
        }

        ksort($groupedBlueprints);

        return $groupedBlueprints;
    }
}
