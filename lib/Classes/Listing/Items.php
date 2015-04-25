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
	public static function loadList()
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
			$list[$item['itemId']] = \Model\Item::loadById($item['itemId']);
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
		return $this->list[$id];
	}
}
