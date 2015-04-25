<?php
namespace Listing;

/**
 * Description of Characters
 *
 * @author Neithan
 */
class Characters extends \SmartWork\Listing
{
	/**
	 * @return \self
	 */
	public static function loadList()
	{
		$sql = '
			SELECT `characterId`
			FROM characters
			WHERE userid = '.\sqlval($_SESSION['userId']).'
				AND !deleted
		';
		$characterIds = query($sql, true);
		$obj = new self();

		if (empty($characterIds))
		{
			return $obj;
		}

		$list = array();
		foreach ($characterIds as $character)
		{
			$list[$character['characterId']] = \Model\Character::loadById($character['characterId']);
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
