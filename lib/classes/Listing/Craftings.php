<?php
namespace Listing;
/**
 * Description of Craftings
 *
 * @author Neithan
 */
class Craftings extends \SmartWork\Listing
{
	public static function loadList($onlyUnfinished = false)
	{
		$sql = '
			SELECT `craftingId`
			FROM craftings
			WHERE `userId` = '.\sqlval($_SESSION['userId']).'
				AND !deleted
				'.($onlyUnfinished ? 'AND !done' : '').'
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
