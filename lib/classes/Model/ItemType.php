<?php
namespace Model;

/**
 * Description of ItemType
 *
 * @author Neithan
 */
class ItemType extends \SmartWork\Model
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
	 * @var string
	 */
	protected $type;

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
				`type`,
				`talentPoints`,
				`time`
			FROM itemTypes
			WHERE `itemTypeId` = '.\sqlval($id).'
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
			INSERT INTO itemTypes
			SET name = '.\sqlval($data['name']).',
				talentPoints = '.\sqlval($data['talentPoints']).',
				time = '.\sqlval($data['time']).'
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

	public function getType()
	{
		return $this->type;
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
			UPDATE itemTypes
			SET deleted = 1
			WHERE `itemTypeId` = '.\sqlval($this->itemTypeId).'
		';
		return query($sql);
	}

	public function getAsArray()
	{
		return array(
			'itemTypeId' => $this->getItemTypeId(),
			'name' => $this->getName(),
			'talentPoints' => $this->getTalentPoints(),
			'time' => $this->getTime(),
		);
	}
}
