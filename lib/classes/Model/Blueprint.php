<?php
namespace Model;

/**
 * Description of Blueprint
 *
 * @author Neithan
 */
class Blueprint extends \Model
{
	/**
	 * @var integer
	 */
	protected $blueprintId;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var \Model\Item
	 */
	protected $item;

	/**
	 * @var \Model\ItemType
	 */
	protected $itemType;

	/**
	 * @var string
	 */
	protected $materialForceModificator;

	/**
	 * @var integer
	 */
	protected $upgradeHitPoints;

	/**
	 * @var integer
	 */
	protected $upgradeBreakFactor;

	/**
	 * @var integer
	 */
	protected $upgradeInitiative;

	/**
	 * @var string
	 */
	protected $upgradeForceModificator;

	/**
	 * @var array
	 */
	protected $materialList;

	/**
	 * @var array
	 */
	protected $techniqueList;

	/**
	 * @param integer $id
	 *
	 * @return \self
	 */
	public static function loadById($id)
	{
		$sql = '
			SELECT
				`blueprintId`,
				`name`,
				`itemId`,
				`itemTypeId`,
				`materialForceModificator`,
				`upgradeHitPoints`,
				`upgradeBreakFactor`,
				`upgradeInitiative`,
				`upgradeForceModificator`
			FROM blueprints
			WHERE `blueprintId` = '.\sqlval($id).'
				AND !`deleted`
		';
		$blueprint = query($sql);
		$obj = new self();
		$obj->fill($blueprint);
		$obj->loadMaterials();
		$obj->loadTechniques();

		return $obj;
	}

	public static function create($data)
	{
		if (!$data['name'] && !$data['itemId'] && count($data['material']) === 0)
		{
			return false;
		}

		$weaponForceModificatorString = '';

		if (!empty($data['materialForceModificator']))
		{
			foreach ($data['materialForceModificator'] as $materialForceModificator)
			{
				$weaponForceModificatorString .= $materialForceModificator . ' || ';
			}
		}

		$weaponForceModificators = \Helper\WeaponModificator::getWeaponModificatorArray(substr($weaponForceModificatorString, 0, -2));
		$upgradeWeaponModificator = \Helper\WeaponModificator::toWeaponModificatorArray($data['upgradeWeaponModificator']['attack'], $data['upgradeWeaponModificator']['parade']);

		$sql = '
			INSERT INTO blueprints
			SET name = '.\sqlval($data['name']).',
				userId = '.\sqlval($data['userId']).',
				itemId = '.\sqlval($data['itemId']).',
				itemTypeId = '.\sqlval($data['itemTypeId']).',
				materialForceModificator = '.\sqlval(json_encode($weaponForceModificators)).',
				upgradeHitPoints = '.\sqlval($data['upgradeHitPoints']).',
				upgradeBreakFactor = '.\sqlval($data['upgradeBreakFactor']).',
				upgradeInitiative = '.\sqlval($data['upgradeInitiative']).',
				upgradeForceModificator = '.\sqlval(json_encode($upgradeWeaponModificator)).'
		';
		$blueprintId = query($sql);

		foreach ($data['material'] as $key => $material)
		{
			$sql = '
				SELECT
					`materialAssetId`,
					`percentage`
				FROM materialAssets
				WHERE `materialId` = '.\sqlval($material).'
					AND !deleted
				ORDER BY percentage DESC
			';
			$materialAssets = \query($sql, true);

			foreach ($materialAssets as $materialAsset)
			{
				if ($data['percentage'][$key] >= $materialAsset['percentage'])
				{
					$materialAssetId = $materialAsset['materialAssetId'];
					break;
				}
			}

			$sql = '
				INSERT INTO materialsToBlueprints
				SET materialId = '.\sqlval($material).',
					blueprintId = '.\sqlval($blueprintId).',
					materialAssetId = '.\sqlval($materialAssetId).',
					percentage = '.\sqlval($data['percentage'][$key]).'
			';
			query($sql);
		}

		if (!empty($data['technique']))
		{
			foreach ($data['technique'] as $technique)
			{
				$sql = '
					INSERT INTO techniquesToBlueprints
					SET techniqueId = '.\sqlval($technique).',
						blueprintId = '.\sqlval($blueprintId).'
				';
				query($sql);
			}
		}

		return true;
	}

	public function fill($data)
	{
		foreach ($data as $key => $value)
		{
			if ($key === 'itemId')
			{
				$this->item = \Model\Item::loadById($value);
			}
			elseif ($key === 'itemTypeId')
			{
				$this->itemType = \Model\ItemType::loadById($value);
			}
			elseif ($key === 'twoHanded' || $key === 'improvisational')
			{
				$this->$key = (bool) $value;
			}
			elseif (property_exists($this, $key))
			{
				$this->$key = $this->castToType($value);
			}
		}
	}

	public function loadMaterials()
	{
		$sql = '
			SELECT
				`materialId`,
				`materialAssetId`,
				percentage
			FROM materialsToBlueprints
			WHERE `blueprintId` = '.\sqlval($this->blueprintId).'
				AND !deleted
		';
		$materialIds = query($sql, true);

		$list = array();
		foreach ($materialIds as $material)
		{
			$list[$material['materialId']] = array(
				'material' => \Model\Material::loadById($material['materialId']),
				'materialAsset' => \Model\MaterialAsset::loadById($material['materialAssetId']),
				'percentage' => intval($material['percentage']),
			);
		}

		$this->materialList = $list;
	}

	public function loadTechniques()
	{
		$sql = '
			SELECT `techniqueId`
			FROM techniquesToBlueprints
			WHERE `blueprintId` = '.\sqlval($this->blueprintId).'
				AND !deleted
		';
		$techniqueIds = query($sql, true);

		$list = array();
		if (!empty($techniqueIds))
		{
			foreach ($techniqueIds as $technique)
			{
				$list[$technique['techniqueId']] = \Model\Technique::loadById($technique['techniqueId']);
			}
		}

		$this->techniqueList = $list;
	}

	public function getBlueprintId()
	{
		return $this->blueprintId;
	}

	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return \Model\Item
	 */
	public function getItem()
	{
		return $this->item;
	}

	/**
	 * @return \Model\ItemType
	 */
	public function getItemType()
	{
		return $this->itemType;
	}

	public function getMaterialForceModificator()
	{
		return json_decode($this->materialForceModificator, true);
	}

	public function getUpgradeHitPoints()
	{
		return $this->upgradeHitPoints;
	}

	public function getUpgradeBreakFactor()
	{
		return $this->upgradeBreakFactor;
	}

	public function getUpgradeInitiative()
	{
		return $this->upgradeInitiative;
	}

	/**
	 * @return array
	 */
	public function getUpgradeForceModificator()
	{
		return json_decode($this->upgradeForceModificator, true);
	}

	/**
	 * @return array
	 */
	public function getMaterialList()
	{
		return $this->materialList;
	}

	/**
	 * @return array
	 */
	public function getTechniqueList()
	{
		return $this->techniqueList;
	}

	public function getEndPrice()
	{
		$price = $this->getItem()->getPrice();
		$priceFactor = 0;
		$priceFactorBelowOne = 0;
		$moneyHelper = new \Helper\Money();

		foreach ($this->materialList as $item)
		{
			/* @var $material \Model\Material */
			$material = $item['material'];
			$materialAssets = $material->getMaterialAssetListing()->getList();
			krsort($materialAssets);
			$materialPriceCalculated = false;

			/* @var $materialAsset \Model\MaterialAsset */
			foreach ($materialAssets as $materialAsset)
			{
				if (!$materialPriceCalculated)
				{
					if ($materialAsset->getPriceFactor())
					{
						if ($materialAsset->getPriceFactor() >= 1)
						{
							$priceFactor += $materialAsset->getPriceFactor();
						}
						else
						{
							if (!$priceFactorBelowOne)
							{
								$priceFactorBelowOne = $materialAsset->getPriceFactor();
							}
							else
							{
								$priceFactorBelowOne *= $materialAsset->getPriceFactor();
							}
						}
					}
					elseif ($materialAsset->getPriceWeight())
					{
						$price += ($this->weight * ($item['percentage'] / 100)) * $materialAsset->getPriceWeightRaw();
					}

					$materialPriceCalculated = true;
				}
			}
		}

		/* @var $technique \Model\Technique */
		foreach ($this->techniqueList as $technique)
		{
			if ($technique->getUnsellable())
			{
				$translator = \Translator::getInstance();
				return $translator->getTranslation('unsellable');
			}

			if ($technique->getPriceFactor() >= 1)
			{
				$priceFactor += $technique->getPriceFactor();
			}
			else
			{
				if (!$priceFactorBelowOne)
				{
					$priceFactorBelowOne = $technique->getPriceFactor();
				}
				else
				{
					$priceFactorBelowOne *= $technique->getPriceFactor();
				}
			}
		}

		$priceFactor += $this->getUpgradeHitPoints() * 3;
		$priceFactor += $this->getUpgradeBreakFactor() * -2;
		$priceFactor += $this->getUpgradeInitiative() * 5;

		if ($this->getUpgradeForceModificator())
		{
			$upgradeForceModificator = $this->getUpgradeForceModificator();

			$priceFactor += ($upgradeForceModificator[0][0]['attack'] + $upgradeForceModificator[0][0]['parade']) * 5;
		}

		if ($priceFactor > 0)
		{
			$price *= $priceFactor;
		}

		if ($priceFactorBelowOne > 0)
		{
			$price *= $priceFactorBelowOne;
		}

		return number_format($moneyHelper->exchange($price, 'K', 'S'), 0, ',', '.') . ' S';
	}

	public function getTimeUnits()
	{
		$time = $this->getItemType()->getTime();

		foreach ($this->getMaterialList() as $item)
		{
			$materialAssetList = $item['material']->getMaterialAssetListing()->getList();
			krsort($materialAssetList);

			/* @var $materialAsset \Model\MaterialAsset */
			foreach ($materialAssetList as $materialAsset)
			{
				$time *= $materialAsset->getTimeFactor();
			}
		}

		/* @var $technique \Model\Technique */
		foreach ($this->getTechniqueList() as $technique)
		{
			$time *= $technique->getTimeFactor();
		}

		return round($time);
	}

	/**
	 * @return array
	 */
	public function getResultingStats()
	{
		$translator = \Translator::getInstance();

		$breakFactor = $this->item->getBreakFactor();
		$initiative = $this->item->getInitiative();
		$forceModificatorList = array_merge(
			$this->getMaterialForceModificator(),
			$this->getUpgradeForceModificator()
		);

		foreach ($this->getMaterialList() as $item)
		{
			/* @var $material \Model\Material */
			$material = $item['material'];
			$materialAssetList = $material->getMaterialAssetListing()->getList();
			usort($materialAssetList, array(__CLASS__, 'compareMaterialAssetsPercentage'));

			/* @var $materialAsset \Model\MaterialAsset */
			foreach ($materialAssetList as $materialAsset)
			{
				if ($materialAsset->getPercentage() > $item['percentage'])
				{
					continue;
				}

				$breakFactor += $materialAsset->getBreakFactor();
				break;
			}
		}

		/* @var $technique \Model\Technique */
		foreach ($this->getTechniqueList() as $technique)
		{
			$breakFactor += $technique->getBreakFactor();
		}

		$forceModificator = array_pop($this->item->getWeaponModificator());

		foreach ($forceModificatorList as $forceMod)
		{
			$forceModificator['attack'] += $forceMod['attack'];
			$forceModificator['parade'] += $forceMod['parade'];
		}

		$hitPoints = $this->getEndHitPoints();
		$hitPointsString = $hitPoints['dices']
			.$translator->getTranslation($hitPoints['diceType']);
		$initiative += $this->getUpgradeInitiative();
		$breakFactor += $this->getUpgradeBreakFactor();

		return array(
			'name' => $this->getName().' ('.$this->item->getName().')',
			'hitPoints' => $hitPointsString.sprintf('%+d', $hitPoints['add'] + $hitPoints['material']),
			'weight' => $this->item->getWeight(),
			'breakFactor' => $breakFactor,
			'initiative' => $initiative,
			'price' => $this->getEndPrice(),
			'forceModificator' => \Helper\WeaponModificator::format($forceModificator),
			'notes' => $this->item->getNotes(),
			'time' => $this->getTimeUnits().' '.$translator->getTranslation('tu'),
		);
	}

	public function remove()
	{
		$sql = '
			UPDATE materialstoblueprints
			SET deleted = 1
			WHERE `blueprintId` = '.\sqlval($this->blueprintId).'
		';
		\query($sql);
		$sql = '
			UPDATE techniquestoblueprints
			SET deleted = 1
			WHERE `blueprintId` = '.\sqlval($this->blueprintId).'
		';
		\query($sql);
		$sql = '
			UPDATE blueprints
			SET deleted = 1
			WHERE `blueprintId` = '.\sqlval($this->blueprintId).'
		';
		\query($sql);
	}

	public function getAsArray()
	{
		return array(
			'id' => $this->getBlueprintId(),
			'name' => $this->getName(),
			'item' => $this->getItem(),
			'itemType' => $this->getItemType(),
			'materialForceModificator' => $this->getMaterialForceModificator(),
			'upgradeHitPoints' => $this->getUpgradeHitPoints(),
			'upgradeBreakFactor' => $this->getUpgradeBreakFactor(),
			'upgradeInitiative' => $this->getUpgradeInitiative(),
			'upgradeForceModificator' => $this->getUpgradeForceModificator(),
		);
	}

	/**
	 * @return array
	 */
	public function getEndHitPoints()
	{
		$data = array(
			'dices' => $this->item->getHitPointsDice(),
			'diceType' => $this->item->getHitPointsDiceType(),
			'add' => $this->item->getHitPoints() + $this->getUpgradeHitPoints(),
			'material' => 0,
		);

		/* @var $technique \Model\Technique */
		foreach ($this->getTechniqueList() as $technique)
		{
			$data['material'] += $technique->getHitPoints();
		}

		foreach ($this->getMaterialList() as $item)
		{
			/* @var $material \Model\Material */
			$material = $item['material'];
			$materialAssetList = $material->getMaterialAssetListing()->getList();
			usort($materialAssetList, array(__CLASS__, 'compareMaterialAssetsPercentage'));

			/* @var $materialAsset \Model\MaterialAsset */
			foreach ($materialAssetList as $materialAsset)
			{
				if ($materialAsset->getPercentage() > $item['percentage'])
				{
					continue;
				}

				$data['material'] += $materialAsset->getHitPoints();
				break;
			}
		}

		return $data;
	}

	/**
	 * @param \Model\MaterialAsset $a
	 * @param \Model\MaterialAsset $b
	 *
	 * @return int
	 */
	public static function compareMaterialAssetsPercentage($a, $b)
	{
		if ($a->getPercentage() == $b->getPercentage())
		{
			return 0;
		}

		return ($a->getPercentage() < $b->getPercentage()) ? +1 : -1;
	}
}
