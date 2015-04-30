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
 * Model class for the blueprints.
 *
 * @package Model
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Blueprint extends \SmartWork\Model
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
	protected $damageType;

	/**
	 * @var string
	 */
	protected $materialWeaponModificator;

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
	protected $upgradeWeaponModificator;

	/**
	 * @var array
	 */
	protected $materialList;

	/**
	 * @var array
	 */
	protected $techniqueList;

	/**
	 * Load the blueprint for the given id.
	 *
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
				`damageType`,
				`materialWeaponModificator`,
				`upgradeHitPoints`,
				`upgradeBreakFactor`,
				`upgradeInitiative`,
				`upgradeWeaponModificator`
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

	/**
	 * Create a new blueprint from the given array.
	 * array(
	 *     'name' => 'test',
	 *     'userId' => 1,
	 *     'itemId' => 1,
	 *     'itemTypeId => 1,
	 *     'damageType' => 'damage',
	 *     'material' => array(
	 *         0 => 1,
	 *     ),
	 *     'percentage' => array(
	 *         0 => 100
	 *     ),
	 *     'materialWeaponModificator' => '0/0',
	 *     'technique' => array(
	 *         0 => 1,
	 *     )
	 *     'upgradeHitPoints' => 0,
	 *     'upgradeBreakFactor' => 0,
	 *     'upgradeInitiative' => 0,
	 *     'upgradeWeaponModificator' => '0/0',
	 * )
	 *
	 * @param array $data
	 *
	 * @return boolean
	 */
	public static function create($data)
	{
		if (!$data['name'] && !$data['itemId'] && count($data['material']) === 0)
		{
			return false;
		}

		$weaponModificatorString = '';

		if (!empty($data['materialWeaponModificator']))
		{
			foreach ($data['materialWeaponModificator'] as $materialWeaponModificator)
			{
				$weaponModificatorString .= $materialWeaponModificator . ' || ';
			}
		}

		$weaponModificators = \Helper\WeaponModificator::getWeaponModificatorArray(substr($weaponModificatorString, 0, -2));
		$upgradeWeaponModificator = \Helper\WeaponModificator::toWeaponModificatorArray($data['upgradeWeaponModificator']['attack'], $data['upgradeWeaponModificator']['parade']);

		$sql = '
			INSERT INTO blueprints
			SET name = '.\sqlval($data['name']).',
				userId = '.\sqlval($data['userId']).',
				itemId = '.\sqlval($data['itemId']).',
				itemTypeId = '.\sqlval($data['itemTypeId']).',
				damageType = '.\sqlval($data['damageType']).',
				materialWeaponModificator = '.\sqlval(json_encode($weaponModificators)).',
				upgradeHitPoints = '.\sqlval($data['upgradeHitPoints']).',
				upgradeBreakFactor = '.\sqlval($data['upgradeBreakFactor']).',
				upgradeInitiative = '.\sqlval($data['upgradeInitiative']).',
				upgradeWeaponModificator = '.\sqlval(json_encode($upgradeWeaponModificator)).'
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

			if (empty($materialAssetId))
			{
				$materialAssetId = $materialAssets[0]['materialAssetId'];
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

	/**
	 * Fill the data from the array into the object and cast them to the nearest possible type.
	 *
	 * @param array $data
	 *
	 * @return void
	 */
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
			elseif (property_exists($this, $key))
			{
				$this->$key = $this->castToType($value);
			}
		}
	}

	/**
	 * Load the materials for the blueprint.
	 *
	 * @return void
	 */
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

	/**
	 * Load the techniques for the blueprint.
	 *
	 * @return void
	 */
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

	/**
	 * Get the id of the blueprint.
	 *
	 * @return integer
	 */
	public function getBlueprintId()
	{
		return $this->blueprintId;
	}

	/**
	 * Get the name of the blueprint.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the item which the blueprint is based on.
	 *
	 * @return \Model\Item
	 */
	public function getItem()
	{
		return $this->item;
	}

	/**
	 * Get the item type of the blueprint.
	 *
	 * @return \Model\ItemType
	 */
	public function getItemType()
	{
		return $this->itemType;
	}

	/**
	 * Get the damage type, may be damage or stamina.
	 *
	 * @return string
	 */
	public function getDamageType()
	{
		return $this->damageType;
	}

	/**
	 * Get the material weapon modificator as an array.
	 *
	 * @return array
	 */
	public function getMaterialWeaponModificator()
	{
		return json_decode($this->materialWeaponModificator, true);
	}

	/**
	 * Get the upgrad hit points value.
	 *
	 * @return integer
	 */
	public function getUpgradeHitPoints()
	{
		return $this->upgradeHitPoints;
	}

	/**
	 * Get the upgrade break factor value.
	 *
	 * @return integer
	 */
	public function getUpgradeBreakFactor()
	{
		return $this->upgradeBreakFactor;
	}

	/**
	 * Get the upgrade initiative value.
	 *
	 * @return integer
	 */
	public function getUpgradeInitiative()
	{
		return $this->upgradeInitiative;
	}

	/**
	 * Get the upgrade weapon modificator values.
	 *
	 * @return array
	 */
	public function getUpgradeWeaponModificator()
	{
		return json_decode($this->upgradeWeaponModificator, true);
	}

	/**
	 * Get the material list.
	 *
	 * @return array
	 */
	public function getMaterialList()
	{
		return $this->materialList;
	}

	/**
	 * Get the techniques list.
	 *
	 * @return array
	 */
	public function getTechniqueList()
	{
		return $this->techniqueList;
	}

	/**
	 * Calculate the end price for the blueprint.
	 *
	 * @return string
	 */
	public function getEndPrice()
	{
		$price = $this->getItem()->getPrice();
		$materialPrice = 0;
		$priceFactor = 0;
		$priceFactorBelowOne = 0;
		$moneyHelper = new \Helper\Money();

		foreach ($this->materialList as $item)
		{
			/* @var $material \Model\Material */
			$material = $item['material'];
			/* @var $materialAsset \Model\MaterialAsset */
			$materialAsset = $item['materialAsset'];

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
				$materialPrice += ($this->item->getWeight() * ($item['percentage'] / 100)) * $materialAsset->getPriceWeightRaw();
			}
		}

		/* @var $technique \Model\Technique */
		foreach ($this->techniqueList as $technique)
		{
			if ($technique->getUnsellable())
			{
				$translator = \SmartWork\Translator::getInstance();
				return $translator->gt('unsellable');
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

		if ($this->getUpgradeWeaponModificator())
		{
			$upgradeWeaponModificator = $this->getUpgradeWeaponModificator();

			$priceFactor += ($upgradeWeaponModificator[0]['attack'] + $upgradeWeaponModificator[0]['parade']) * 5;
		}

		if ($priceFactor > 0)
		{
			$price *= $priceFactor;
		}

		if ($priceFactorBelowOne > 0)
		{
			$price *= $priceFactorBelowOne;
		}

		$price += $materialPrice;

		return number_format($moneyHelper->exchange($price, 'K', 'S'), 0, ',', '.') . ' S';
	}

	/**
	 * Get the time units for each proof.
	 *
	 * @return integer
	 */
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
	 * Get the resulting stats for the blueprint.
	 *
	 * @return array
	 */
	public function getResultingStats()
	{
		$translator = \SmartWork\Translator::getInstance();

		$breakFactor = $this->item->getBreakFactor();
		$initiative = $this->item->getInitiative();
		$weaponModificatorList = array_merge(
			$this->getMaterialWeaponModificator(),
			$this->getUpgradeWeaponModificator()
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

		$weaponModificator = array_pop($this->item->getWeaponModificator());

		foreach ($weaponModificatorList as $weaponMod)
		{
			$weaponModificator['attack'] += $weaponMod['attack'];
			$weaponModificator['parade'] += $weaponMod['parade'];
		}

		$hitPoints = $this->getEndHitPoints();
		$hitPointsString = $hitPoints['dices']
			.$translator->gt($hitPoints['diceType']);
		$initiative += $this->getUpgradeInitiative();
		$breakFactor += $this->getUpgradeBreakFactor();
		$damageType = 'damage';

		if ($this->item->getDamageType() == 'stamina' || $this->getDamageType() == 'stamina')
		{
			$damageType = 'stamina';
		}

		return array(
			'name' => $this->getName().' ('.$this->item->getName().')',
			'hitPoints' => \Helper\HitPoints::getHitPointsString(array(
				'hitPointsDice' => $hitPoints['dices'],
				'hitPointsDiceType' => $hitPoints['diceType'],
				'hitPoints' => $hitPoints['add'] + $hitPoints['material'],
				'damageType' => $damageType,
			)),
			'weight' => $this->item->getWeight(),
			'breakFactor' => $breakFactor,
			'initiative' => $initiative,
			'price' => $this->getEndPrice(),
			'weaponModificator' => \Helper\WeaponModificator::format($weaponModificator),
			'notes' => $this->item->getNotes(),
			'time' => $this->getTimeUnits().' '.$translator->gt('tu'),
		);
	}

	/**
	 * Remove the blueprint.
	 *
	 * @return void
	 */
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

	/**
	 * Get the blueprint as array.
	 *
	 * @return array
	 */
	public function getAsArray()
	{
		return array(
			'id' => $this->getBlueprintId(),
			'name' => $this->getName(),
			'item' => $this->getItem(),
			'itemType' => $this->getItemType(),
			'materialWeaponModificator' => $this->getMaterialWeaponModificator(),
			'upgradeHitPoints' => $this->getUpgradeHitPoints(),
			'upgradeBreakFactor' => $this->getUpgradeBreakFactor(),
			'upgradeInitiative' => $this->getUpgradeInitiative(),
			'upgradeWeaponModificator' => $this->getUpgradeWeaponModificator(),
		);
	}

	/**
	 * Get the end hit points consisting of the item hit points, the upgrade hit points, the
	 * material hit points and the technique hit points.
	 *
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
	 * Compare method for sorting the material assets along their percentages
	 *
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
