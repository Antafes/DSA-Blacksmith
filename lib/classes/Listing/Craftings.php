<?php
namespace Listing;
/**
 * Description of Craftings
 *
 * @author Neithan
 */
class Craftings extends \Listing
{
	public static function loadList()
	{
		$sql = '
			SELECT `craftingId`
			FROM craftings
			WHERE `userId` = '.\sqlval($_SESSION['userId']).'
			ORDER BY done, `name`
		';
		$craftingIds = query($sql, true);
		$obj = new self();

		if (empty($craftingIds))
		{
			return $obj;
		}

		$list = array();
		foreach ($craftingIds as $crafting)
		{
			$list[$crafting['craftingId']] = \Model\Crafting::loadById($crafting['craftingId']);
		}

		$obj->setList($list);

		return $obj;
	}

	public function getById($id)
	{
		return $this->list[$id];
	}
}
