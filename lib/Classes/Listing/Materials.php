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
 * List class for materials.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Materials extends \SmartWork\Listing
{
	/**
	 * Load all available materials.
	 *
	 * @return \self
	 */
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

	/**
	 * Get a single material by the given id.
	 *
	 * @param integer $id
	 *
	 * @return \Model\Material
	 */
	public function getById($id)
	{
		return $this->list[$id];
	}
}