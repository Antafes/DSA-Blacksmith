<?php
namespace Model;

/**
 * Description of MaterialType
 *
 * @author Neithan
 */
class MaterialType extends \Model
{
	protected $materialTypeId;
	protected $name;

	/**
	 * @param integer $id
	 *
	 * @return \self
	 */
	public static function loadById($id)
	{
		$sql = '
			SELECT
				`materialTypeId`,
				`name`
			FROM materialTypes
			WHERE `materialTypeId` = '.sqlval($id).'
				AND !deleted
		';
		$materialType = query($sql);
		$obj = new self();
		$obj->fill($materialType);

		return $obj;
	}

	public static function create($data)
	{
		if (!$data['name'])
			return false;

		$sql = '
			INSERT INTO materialTypes
			SET name = '.sqlval(trim($data['name'])).'
		';
		$id = query($sql);

		return array(
			'id' => $id,
			'name' => trim($data['name']),
		);
	}

	function getMaterialTypeId()
	{
		return $this->materialTypeId;
	}

	function getName()
	{
		return $this->name;
	}

	public function getAsArray()
	{
	}
}
