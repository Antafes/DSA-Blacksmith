<?php
/**
 * Part of the dsa blacksmith
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
namespace Listing;

/**
 * List class for blueprints.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Blueprints extends \SmartWork\Listing
{
	/**
	 * Load all available blueprints for the logged in user.
	 *
	 * @return \self
	 */
	public static function loadList()
	{
		$sql = '
			SELECT `blueprintId`
			FROM blueprints
			WHERE userid = '.\sqlval($_SESSION['userId']).'
				AND !deleted
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
	 * Get a single blueprint by its id.
	 *
	 * @param integer $id
	 *
	 * @return \Model\Blueprint
	 */
	public function getById($id)
	{
		return $this->list[$id];
	}
}
