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
 * List class for the items.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Items extends \SmartWork\Listing
{
    /**
     * Load all items.
     *
     * @return \self
     */
    public static function loadList($groupBy = 'itemType')
    {
        $sql = '
            SELECT `itemId`
            FROM items
            WHERE !deleted
            ORDER BY `name`
        ';
        $itemIds = query($sql, true);
        $obj = new self();

        if (empty($itemIds))
        {
            return $obj;
        }

        $list = array();
        foreach ($itemIds as $item)
        {
            $itemObject = \Model\Item::loadById($item['itemId']);

            if (!is_array($list[$itemObject->getItemType()]))
            {
                $list[$itemObject->getItemType()] = array();
            }

            $list[$itemObject->getItemType()][$item['itemId']] = $itemObject;
        }

        $obj->setList($list);

        return $obj;
    }

    /**
     * Get a single item by the given id.
     *
     * @param integer $id
     *
     * @return \Model\Item
     */
    public function getById($id)
    {
        foreach ($this->list as $items)
        {
            if (array_key_exists($id, $items))
            {
                return $items[$id];
            }
        }
    }

    /**
     * Get the list of items, optionally filtered by the item type.
     *
     * @param string|null $itemTypeFilter The item type to filter
     *
     * @return array
     */
    public function getList($itemTypeFilter = null)
    {
        $list = parent::getList();

        if (!$itemTypeFilter)
        {
            return $list;
        }

        foreach ($list as $itemType => $items)
        {
            if ($itemType == $itemTypeFilter)
            {
                return $items;
            }
        }

        return array();
    }
}
