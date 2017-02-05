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
 * List class for the techniques.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Techniques extends \SmartWork\Listing
{
    /**
     * Load all available techniques.
     *
     * @return \self
     */
    public static function loadList()
    {
        $sql = '
            SELECT `techniqueId`
            FROM techniques
            WHERE !deleted
            ORDER BY `name`
        ';
        $techniqueIds = query($sql, true);
        $obj = new self();

        if (empty($techniqueIds))
        {
            return $obj;
        }

        $list = array();
        foreach ($techniqueIds as $technique)
        {
            $list[$technique['techniqueId']] = \Model\Technique::loadById($technique['techniqueId']);
        }

        $obj->setList($list);

        return $obj;
    }

    /**
     * Get a single technique for the given id.
     *
     * @param integer $id
     *
     * @return \Model\Technique
     */
    public function getById($id)
    {
        return $this->list[$id];
    }
}
