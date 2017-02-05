<?php
/**
 * Part of the dsa blacksmith.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
namespace Listing;

/**
 * List class for craftings.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Craftings extends \SmartWork\Listing
{
    /**
     * Load all craftings for the logged in user.
     *
     * @param boolean $onlyUnfinished
     *
     * @return \self
     */
    public static function loadList($onlyUnfinished = false)
    {
        $sql = '
            SELECT `craftingId`
            FROM craftings
            WHERE `userId` = '.\sqlval($_SESSION['userId']).'
                AND !deleted
                '.($onlyUnfinished ? 'AND !done' : '').'
            ORDER BY done, `name`
        ';
        $craftingIds = query($sql, true);
        $obj = new self();

        if (empty($craftingIds))
        {
            return $obj;
        }

        $list = array();
        foreach ($craftingIds as $crafting)
        {
            $list[$crafting['craftingId']] = \Model\Crafting::loadById($crafting['craftingId']);
        }

        $obj->setList($list);

        return $obj;
    }

    /**
     * Get a single crafting for the given id.
     *
     * @param integer $id
     *
     * @return \Model\Crafting
     */
    public function getById($id)
    {
        return $this->list[$id];
    }
}
