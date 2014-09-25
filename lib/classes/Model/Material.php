<?php
namespace Model;

class Material extends \Model
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
		$material = query($sql);
		$obj = new self();
		$obj->fill($material);
		$obj->loadMaterialAssets();

		return $obj;
	}

	public function loadMaterialAssets()
	{
		$this->materialAssetListing = \Listing\MaterialAssets::loadListMaterial($this->getMaterialId());
	}

	/**
	 * @param array $data
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
		$id = query($sql);

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
				'forceModificator' => $data['forceModificator'][$key],
			));
		}

		return true;
	}

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

	public function getMaterialId()
	{
		return $this->materialId;
	}

	public function getMaterialType()
	{
		return $this->materialType->getName();
	}

	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return \Listing\MaterialAssets
	 */
	public function getMaterialAssetListing()
	{
		return $this->materialAssetListing;
	}

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

	public function getAdditional()
	{
		return json_decode($this->additional, true);
	}

	public function remove()
	{
		$sql = '
			UPDATE materials, materialAssets
			SET materials.deleted = 1,
				materialAssets.deleted = 1
			WHERE materials.`materialId` = '.\sqlval($this->materialId).'
				AND materialAssets.`materialId` = materials.`materialId`
		';
		return query($sql);
	}

	/**
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