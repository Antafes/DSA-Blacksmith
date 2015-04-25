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
 * List class for the item types.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class ItemTypes extends \SmartWork\Listing
{
	/**
	 * Load all item types.
	 *
	 * @return \self
	 */
	public static function loadList()
	{
		$sql = '
			SELECT `itemTypeId`
			FROM itemTypes
			WHERE !deleted
			ORDER BY `name`
		';
		$itemTypeIds = query($sql, true);
		$obj = new self();

		if (empty($itemTypeIds))
		{
			return $obj;
		}

		$list = array();
		foreach ($itemTypeIds as $itemType)
		{
			$list[$itemType['itemTypeId']] = \Model\ItemType::loadById($itemType['itemTypeId']);
		}

		$obj->setList($list);

		return $obj;
	}

	/**
	 * Get a single item type by the given id.
	 *
	 * @param integer $id
	 *
	 * @return \Model\ItemType
	 */
	public function getById($id)
	{
		return $this->list[$id];
	}
}
