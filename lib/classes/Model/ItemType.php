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
	protected $priceFactor;

	/**
	 * @var float
	 */
	protected $time;


	public static function loadById($id)
	{
		$sql = '
			SELECT
				`itemTypeId`,
				`name`,
				`priceFactor`,
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
		if (!$data['name'] && !$data['priceFactor'] && !$data['time'])
			return false;

		$data['priceFactor'] = str_replace(',', '.', $data['priceFactor']);
		$data['time'] = str_replace(',', '.', $data['time']);

		$sql = '
			INSERT INTO itemtypes
			SET name = '.sqlval($data['name']).',
				priceFactor = '.sqlval($data['priceFactor']).',
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

	public function getPriceFactor()
	{
		return $this->priceFactor;
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
