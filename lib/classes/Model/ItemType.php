<?php
namespace Model;

/**
 * Description of ItemType
 *
 * @author Neithan
 */
class ItemType extends \Model
{
	/**
	 * @var integer
	 */
	protected $itemTypeId;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var float
	 */
	protected $talentPoints;

	/**
	 * @var float
	 */
	protected $time;

	/**
	 * @param integer $id
	 *
	 * @return \self
	 */
	public static function loadById($id)
	{
		$sql = '
			SELECT
				`itemTypeId`,
				`name`,
				`talentPoints`,
				`time`
			FROM itemtypes
			WHERE `itemTypeId` = '.sqlval($id).'
				AND !deleted
		';
		$itemType = query($sql);
		$obj = new self();

		$obj->fill($itemType);

		return $obj;
	}

	public static function create($data)
	{
		if (!$data['name'] && !$data['talentPoints'] && !$data['time'])
			return false;

		$data['time'] = str_replace(',', '.', $data['time']);

		$sql = '
			INSERT INTO itemtypes
			SET name = '.sqlval($data['name']).',
				talentPoints = '.sqlval($data['talentPoints']).',
				time = '.sqlval($data['time']).'
		';
		query($sql);

		return true;
	}

	public function getItemTypeId()
	{
		return $this->itemTypeId;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getTalentPoints()
	{
		return $this->talentPoints;
	}

	public function getTime()
	{
		return $this->time;
	}

	public function remove()
	{
		$sql = '
			UPDATE itemtypes
			SET deleted = 1
			WHERE `itemTypeId` = '.sqlval($this->itemTypeId).'
		';
		return query($sql);
	}
}
