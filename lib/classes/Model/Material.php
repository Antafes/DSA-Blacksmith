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
	 * @var float
	 */
	protected $timeFactor;

	/**
	 * @var float
	 */
	protected $priceFactor;

	/**
	 * Weight in ounces
	 *
	 * @var integer
	 */
	protected $priceWeight;

	/**
	 * @var integer
	 */
	protected $proof;

	/**
	 * @var integer
	 */
	protected $breakFactor;

	/**
	 * @var integer
	 */
	protected $hitPoints;

	/**
	 * @var integer
	 */
	protected $armor;

	/**
	 * @var string
	 */
	protected $forceModificator;

	/**
	 * A JSON encoded string of additional modifiers
	 *
	 * @var string
	 */
	protected $additional;

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
				`timeFactor`,
				`priceFactor`,
				`priceWeight`,
				proof,
				`breakFactor`,
				`hitPoints`,
				armor,
				`forceModificator`,
				additional
			FROM materials
			WHERE `materialId` = '.sqlval($id).'
				AND !deleted
		';
		$material = query($sql);
		$obj = new self();
		$obj->fill($material);

		return $obj;
	}

	/**
	 * @param array $data
	 * @return boolean
	 */
	public static function create($data)
	{
		if (!$data['name'] || !$data['materialTypeId'] || (!$data['priceFactor'] && !$data['priceWeight']))
			return false;

		$additional = array();
		if (!empty(trim($data['additional'])))
		{
			preg_match_all('/(\w.*?) +(\w.*?)(?=(\r\n|\r|\n))/m', trim($data['additional']), $matches, PREG_SET_ORDER);
			foreach ($matches as $match)
			{
				$additional[$match[1]] = $match[2];
			}
		}

		if (stripos($data['timeFactor'], ','))
		{
			$data['timeFactor'] = str_replace(',', '.', $data['timeFactor']);
		}

		if (empty($data['timeFactor']))
		{
			$data['timeFactor'] = 1;
		}

		if (stripos($data['priceFactor'], ','))
		{
			$data['priceFactor'] = str_replace(',', '.', $data['priceFactor']);
		}

		$priceWeight = 0;
		if (!empty(trim($data['priceWeight'])))
		{
			$moneyHelper = new \Helper\Money();
			$priceWeight = $moneyHelper->exchange($data['priceWeight'], $data['currency']);
		}

		if ($data['forceModificator'])
		{
			$forceModificators = \Helper\ForceModificator::getForceModificatorArray($data['forceModificator']);
		}

		$sql = '
			INSERT INTO materials
			SET materialTypeId = '.sqlval($data['materialTypeId']).',
				name = '.sqlval($data['name']).',
				timeFactor = '.sqlval($data['timeFactor']).',
				priceFactor = '.sqlval($data['priceFactor']).',
				priceWeight = '.sqlval($data['priceWeight']).',
				proof = '.sqlval($data['proof']).',
				breakFactor = '.sqlval($data['breakFactor']).',
				hitPoints = '.sqlval($data['hitPoints']).',
				armor = '.sqlval($data['armor']).',
				forceModificator = '.sqlval(json_encode($forceModificators)).',
				additional = '.sqlval(json_encode($additional)).'
		';
		query($sql);

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

	public function getTimeFactor()
	{
		return $this->timeFactor;
	}

	public function getPriceFactor()
	{
		return $this->priceFactor;
	}

	public function getPriceWeight()
	{
		return $this->priceWeight;
	}

	public function getProof()
	{
		return $this->proof;
	}

	public function getBreakFactor()
	{
		return $this->breakFactor;
	}

	public function getHitPoints()
	{
		return $this->hitPoints;
	}

	public function getArmor()
	{
		return $this->armor;
	}

	public function getForceModificator()
	{
		return json_decode($this->forceModificator, true);
	}

	public function getAdditional()
	{
		return json_decode($this->additional, true);
	}

	public function remove()
	{
		$sql = '
			UPDATE materials
			SET deleted = 1
			WHERE `materialId` = '.sqlval($this->materialId).'
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
			'timeFactor' => $this->getTimeFactor(),
			'priceFactor' => $this->getPriceFactor(),
			'priceWeight' => $this->getPriceWeight(),
			'proof' => $this->getProof(),
			'breakFactor' => $this->getBreakFactor(),
			'hitPoints' => $this->getHitPoints(),
			'armor' => $this->getArmor(),
			'forceModificator' => $this->getForceModificator(),
			'additional' => $this->getAdditional(),
		);
	}
}