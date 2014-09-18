<?php
namespace Listing;

/**
 * Description of Blueprints
 *
 * @author Neithan
 */
class Blueprints extends \Listing
{
	public static function loadList()
	{
		$sql = '
			SELECT `blueprintId`
			FROM blueprints
			WHERE !deleted
		';
		$blueprintIds = query($sql, true);
		$obj = new self();

		if (empty($blueprintIds))
		{
			return $obj;
		}

		$list = array();
		foreach ($blueprintIds as $blueprint)
		{
			$list[$blueprint['blueprintId']] = \Model\Blueprint::loadById($blueprint['blueprintId']);
		}

		$obj->setList($list);

		return $obj;
	}

	/**
	 * @param integer $id
	 *
	 * @return \Model\Blueprint
	 */
	public function getById($id)
	{
		return $this->list[$id];
	}
}
