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
 * List class for material types.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class MaterialTypes extends \SmartWork\Listing
{
    /**
     * Load all available material types.
     *
     * @return \self
     */
    public static function loadList()
    {
        $sql = '
            SELECT `materialTypeId`
            FROM materialTypes
            WHERE !deleted
            ORDER BY `name`
        ';
        $materialTypeIds = query($sql, true);
        $obj = new self();

        if (empty($materialTypeIds))
        {
            return $obj;
        }

        $list = array();
        foreach ($materialTypeIds as $materialType)
        {
            $list[$materialType['materialTypeId']] = \Model\MaterialType::loadById($materialType['materialTypeId']);
        }

        $obj->setList($list);

        return $obj;
    }

    /**
     * Get a single material type for the given id.
     *
     * @param integer $id
     *
     * @return \Model\MaterialType
     */
    public function getById($id)
    {
        return $this->list[$id];
    }
}
