<?php
namespace Listing;

/**
 * Description of ItemTypes
 *
 * @author Neithan
 */
class ItemTypes extends \Listing
{
	/**
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
	 * @param integer $id
	 *
	 * @return \Model\ItemType
	 */
	public function getById($id)
	{
		return $this->list[$id];
	}
}
