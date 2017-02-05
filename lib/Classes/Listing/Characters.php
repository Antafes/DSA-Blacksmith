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
 * List class for characters.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Characters extends \SmartWork\Listing
{
    /**
     * Load all characters for the logged in user.
     *
     * @return \self
     */
    public static function loadList()
    {
        $sql = '
            SELECT `characterId`
            FROM characters
            WHERE userid = '.\sqlval($_SESSION['userId']).'
                AND !deleted
        ';
        $characterIds = query($sql, true);
        $obj = new self();

        if (empty($characterIds))
        {
            return $obj;
        }

        $list = array();
        foreach ($characterIds as $character)
        {
            $list[$character['characterId']] = \Model\Character::loadById($character['characterId']);
        }

        $obj->setList($list);

        return $obj;
    }

    /**
     * Get a single character by its id.
     *
     * @param integer $id
     *
     * @return \Model\Blueprint
     */
    public function getById($id)
    {
        return $this->list[$id];
    }
}
