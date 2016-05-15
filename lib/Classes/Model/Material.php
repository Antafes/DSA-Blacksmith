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
 * Model class for materials.
 *
 * @package Model
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Material extends \SmartWork\Model
{
	/**
	 * @var integer
	 */
	protected $materialId;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var \Model\MaterialType
	 */
	protected $materialType;

	/**
	 * A JSON encoded string of additional modifiers
	 *
	 * @var string
	 */
	protected $additional;

	/**
	 * @var \Listing\MaterialAssets
	 */
	protected $materialAssetListing;

	/**
	 * Load a material by ID
	 *
	 * @param integer $id
	 *
	 * @return \self
	 */
	public static function loadById($id)
	{
		$sql = '
			SELECT
				`materialId`,
				`materialTypeId`,
				`name`,
				additional
			FROM materials
			WHERE `materialId` = '.\sqlval($id).'
				AND !deleted
		';
		$material = \query($sql);
		$obj = new self();
		$obj->fill($material);
		$obj->loadMaterialAssets();

		return $obj;
	}

	/**
	 * Load the material assets for this material.
	 *
	 * @return void
	 */
	public function loadMaterialAssets()
	{
		$this->materialAssetListing = \Listing\MaterialAssets::loadListMaterial($this->getMaterialId());
	}

	/**
	 * Create a new material and the material assets from the given array.
	 * array(
	 *     'name' => 'test',
	 *     'materialTypeId' => 1,
	 *     'additional' => 'one additional',
	 *     'percentage' => array(
	 *         0 => 50,
	 *         1 => 100,
	 *     ),
	 *     'timeFactor' => array(
	 *         0 => 1,
	 *         1 => 1,
	 *     ),
	 *     'priceFactor' => array(
	 *         0 => 2,
	 *         0 => 1.5,
	 *     ),
	 *     'priceWeight' => array(),
	 *     'currency' => array(
	 *         0 => 'S',
	 *         1 => 'D',
	 *     ),
	 *     'proof' => array(
	 *         0 => 0,
	 *         1 => -1,
	 *     ),
	 *     'breakFactor' => array(
	 *         0 => 1,
	 *         1 => -1,
	 *     ),
	 *     'hitPoints' => array(
	 *         0 => 0,
	 *         1 => 1,
	 *     ),
	 *     'armor' => array(
	 *         0 => 0,
	 *         1 => 0,
	 *     ),
	 *     'weaponModificator' => array(
	 *         0 => '0/0',
	 *         1 => '-1/0',
	 *     ),
	 * )
	 *
	 * @param array $data
	 *
	 * @return boolean
	 */
	public static function create($data)
	{
		if (!$data['name'] || !$data['materialTypeId'])
			return false;

		$additional = array();
		$data['additional'] = trim($data['additional']);
		if (!empty($data['additional']))
		{
			preg_match_all('/(\w.*?) +(\w.*?)(?=(\r\n|\r|\n))/m', trim($data['additional']), $matches, PREG_SET_ORDER);
			foreach ($matches as $match)
			{
				$additional[$match[1]] = $match[2];
			}
		}

		$sql = '
			INSERT INTO materials
			SET materialTypeId = '.\sqlval($data['materialTypeId']).',
				name = '.\sqlval($data['name']).',
				additional = '.\sqlval(json_encode($additional)).'
		';
		$id = \query($sql);

		foreach ($data['percentage'] as $key => $value)
		{
			\Model\MaterialAsset::create(array(
				'materialId' => $id,
				'percentage' => $value,
				'timeFactor' => $data['timeFactor'][$key],
				'priceFactor' => $data['priceFactor'][$key],
				'priceWeight' => $data['priceWeight'][$key],
				'currency' => $data['currency'][$key],
				'proof' => $data['proof'][$key],
				'breakFactor' => $data['breakFactor'][$key],
				'hitPoints' => $data['hitPoints'][$key],
				'armor' => $data['armor'][$key],
				'weaponModificator' => $data['weaponModificator'][$key],
			));
		}

		return true;
	}

	/**
	 * Create a new material and the material assets from the given array.
	 * array(
	 *     'name' => 'test',
	 *     'materialTypeId' => 1,
	 *     'additional' => 'one additional',
	 *     'percentage' => array(
	 *         0 => 50,
	 *         1 => 100,
	 *     ),
	 *     'timeFactor' => array(
	 *         0 => 1,
	 *         1 => 1,
	 *     ),
	 *     'priceFactor' => array(
	 *         0 => 2,
	 *         0 => 1.5,
	 *     ),
	 *     'priceWeight' => array(),
	 *     'currency' => array(
	 *         0 => 'S',
	 *         1 => 'D',
	 *     ),
	 *     'proof' => array(
	 *         0 => 0,
	 *         1 => -1,
	 *     ),
	 *     'breakFactor' => array(
	 *         0 => 1,
	 *         1 => -1,
	 *     ),
	 *     'hitPoints' => array(
	 *         0 => 0,
	 *         1 => 1,
	 *     ),
	 *     'armor' => array(
	 *         0 => 0,
	 *         1 => 0,
	 *     ),
	 *     'weaponModificator' => array(
	 *         0 => '0/0',
	 *         1 => '-1/0',
	 *     ),
	 * )
	 *
	 * @param array $data
	 *
	 * @return boolean
	 */
	public function update($data)
	{
        $update = '';

		$additional = array();
		$data['additional'] = trim($data['additional']);
		if (!empty($data['additional']))
		{
			preg_match_all('/(\w.*?) +(\w.*?)(?=(\r\n|\r|\n))/m', trim($data['additional']), $matches, PREG_SET_ORDER);
			foreach ($matches as $match)
			{
				$additional[$match[1]] = $match[2];
			}
		}

		$sql = '
			UPDATE materials
			SET materialTypeId = '.\sqlval($data['materialTypeId']).',
				name = '.\sqlval($data['name']).',
				additional = '.\sqlval(json_encode($additional)).'
            WHERE `materialId` = '. \sqlval($this->getMaterialId()).'
		';
		\query($sql);

		foreach ($data['percentage'] as $key => $value)
		{
            $materialAsset = MaterialAsset::loadById($data['materialAssetId'][$key]);
            $materialAsset->update(array(
				'percentage' => $value,
				'timeFactor' => $data['timeFactor'][$key],
				'priceFactor' => $data['priceFactor'][$key],
				'priceWeight' => $data['priceWeight'][$key],
				'currency' => $data['currency'][$key],
				'proof' => $data['proof'][$key],
				'breakFactor' => $data['breakFactor'][$key],
				'hitPoints' => $data['hitPoints'][$key],
				'armor' => $data['armor'][$key],
				'weaponModificator' => $data['weaponModificator'][$key],
			));
		}

		return true;
	}

	/**
	 * Fill the objects properties with the given data and cast them if possible to the best
	 * matching type. Only existing properties are filled.
	 *
	 * @param type $data
	 *
	 * @return void
	 */
	public function fill($data)
	{
		foreach ($data as $key => $value)
		{
			if ($key === 'materialTypeId')
			{
				$this->materialType = \Model\MaterialType::loadById($value);
			}
			elseif (property_exists($this, $key))
			{
				$this->$key = $this->castToType($value);
			}
		}
	}

	/**
	 * Get the material id.
	 *
	 * @return integer
	 */
	public function getMaterialId()
	{
		return $this->materialId;
	}

	/**
	 * Get the material type.
	 *
	 * @return string
	 */
	public function getMaterialType()
	{
		return $this->materialType->getName();
	}

	/**
	 * Get the material name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the material asset list object.
	 *
	 * @return \Listing\MaterialAssets
	 */
	public function getMaterialAssetListing()
	{
		return $this->materialAssetListing;
	}

	/**
	 * Get the material assets as an array.
	 *
	 * @return array
	 */
	public function getMaterialAssetArray()
	{
		if ($this->materialAssetListing)
		{
			return $this->materialAssetListing->getAsArray();
		}
		else
		{
			return array();
		}
	}

	/**
	 * Get the additional modificators as an array.
	 *
	 * @return array
	 */
	public function getAdditional()
	{
		return json_decode($this->additional, true);
	}

	/**
	 * Remove the material and its assets.
	 *
	 * @return void
	 */
	public function remove()
	{
		$sql = '
			UPDATE materials, materialAssets
			SET materials.deleted = 1,
				materialAssets.deleted = 1
			WHERE materials.`materialId` = '.\sqlval($this->materialId).'
				AND materialAssets.`materialId` = materials.`materialId`
		';
		\query($sql);
	}

	/**
	 * Get the objects properties as an array.
	 *
	 * @return array
	 */
	public function getAsArray()
	{
		return array(
			'id' => $this->getMaterialId(),
			'name' => $this->getName(),
			'materialType' => $this->getMaterialType(),
			'materialAssets' => $this->getMaterialAssetListing()->getAsArray(),
			'additional' => $this->getAdditional(),
		);
	}
}