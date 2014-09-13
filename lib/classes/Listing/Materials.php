<?php
namespace Listing;

/**
 * Description of Materials
 *
 * @author Neithan
 */
class Materials extends \Listing
{
	public static function loadList()
	{
		$sql = '
			SELECT `materialId`
			FROM materials
			WHERE !deleted
			ORDER BY `name`
		';
		$materialIds = query($sql, true);
		$obj = new self();

		if (empty($materialIds))
		{
			return $obj;
		}

		$list = array();
		foreach ($materialIds as $material)
		{
			$list[$material['materialId']] = \Model\Material::loadById($material['materialId']);
		}

		$obj->setList($list);

		return $obj;
	}

	public function getById($id)
	{
		return $this->list[$id];
	}
}