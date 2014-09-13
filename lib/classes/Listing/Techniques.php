<?php
namespace Listing;

/**
 * Description of Techniques
 *
 * @author Neithan
 */
class Techniques extends \Listing
{
	/**
	 * @return \self
	 */
	public static function loadList()
	{
		$sql = '
			SELECT `techniqueId`
			FROM techniques
			WHERE !deleted
			ORDER BY `name`
		';
		$techniqueIds = query($sql, true);
		$obj = new self();

		if (empty($techniqueIds))
		{
			return $obj;
		}

		$list = array();
		foreach ($techniqueIds as $technique)
		{
			$list[$technique['techniqueId']] = \Model\Technique::loadById($technique['techniqueId']);
		}

		$obj->setList($list);

		return $obj;
	}

	/**
	 * @param integer $id
	 *
	 * @return \Model\Technique
	 */
	public function getById($id)
	{
		return $this->list[$id];
	}
}
