<?php
namespace Listing;

/**
 * Description of MaterialTypes
 *
 * @author Neithan
 */
class MaterialTypes extends \Listing
{
	/**
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
	 * @param integer $id
	 *
	 * @return \Model\MaterialType
	 */
	public function getById($id)
	{
		return $this->list[$id];
	}
}
