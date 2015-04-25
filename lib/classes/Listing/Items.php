<?php
namespace Listing;

/**
 * Description of ItemTypes
 *
 * @author Neithan
 */
class Items extends \SmartWork\Listing
{
	/**
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
	 * @param integer $id
	 *
	 * @return \Model\Item
	 */
	public function getById($id)
	{
		return $this->list[$id];
	}
}
