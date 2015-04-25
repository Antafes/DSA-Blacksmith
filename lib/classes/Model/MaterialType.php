<?php
/**
 * Part of the dsa blacksmith.
 *
 * @package Model
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
namespace Model;

/**
 * Model class for the material types.
 *
 * @package Model
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class MaterialType extends \SmartWork\Model
{
	/**
	 * @var integer
	 */
	protected $materialTypeId;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * Load the material type by the given id.
	 *
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
			WHERE `materialTypeId` = '.\sqlval($id).'
				AND !deleted
		';
		$materialType = \query($sql);
		$obj = new self();
		$obj->fill($materialType);

		return $obj;
	}

	/**
	 * Create a new material type from the given array.
	 * array(
	 *     'name' => 'test',
	 * )
	 *
	 * @param array $data
	 *
	 * @return boolean
	 */
	public static function create($data)
	{
		if (!$data['name'])
			return false;

		$sql = '
			INSERT INTO materialTypes
			SET name = '.\sqlval(trim($data['name'])).'
		';
		$id = query($sql);

		return array(
			'id' => $id,
			'name' => trim($data['name']),
		);
	}

	/**
	 * Get the material type id.
	 *
	 * @return integer
	 */
	function getMaterialTypeId()
	{
		return $this->materialTypeId;
	}

	/**
	 * Get the name of the material type.
	 *
	 * @return string
	 */
	function getName()
	{
		return $this->name;
	}

	/**
	 * Not used
	 *
	 * @return void
	 */
	public function getAsArray()
	{
	}
}
