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
	 * @var integer
	 */
	protected $basePrice;

	/**
	 * @var \Model\ItemType
	 */
	protected $itemType;

	/**
	 * @var boolean
	 */
	protected $twoHanded;

	/**
	 * @var boolean
	 */
	protected $improvisational;

	/**
	 * @var integer
	 */
	protected $baseHitPointsDice;

	/**
	 * @var string
	 */
	protected $baseHitPointsDiceType;

	/**
	 * @var integer
	 */
	protected $baseHitPoints;

	/**
	 * @var integer
	 */
	protected $baseBreakFactor;

	/**
	 * @var integer
	 */
	protected $baseInitiative;

	/**
	 * @var string
	 */
	protected $baseForceModificator;

	/**
	 * @var integer
	 */
	protected $weight;

	/**
	 * @var integer
	 */
	protected $toolsProofModificator;

	/**
	 * @var integer
	 */
	protected $planProofModificator;

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
				`basePrice`,
				`itemTypeId`,
				`twoHanded`,
				improvisational,
				`baseHitPointsDice`,
				`baseHitPointsDiceType`,
				`baseHitPoints`,
				`baseBreakFactor`,
				`baseInitiative`,
				`baseForceModificator`,
				weight,
				`toolsProofModificator`,
				`planProofModificator`,
				`materialForceModificator`,
				`upgradeHitPoints`,
				`upgradeBreakFactor`,
				`upgradeInitiative`,
				`upgradeForceModificator`
			FROM blueprints
			WHERE `blueprintId` = '.sqlval($id).'
				AND !deleted
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
		if (!$data['name'] && !is_numeric($data['basePrice']) && !is_numeric($data['baseHitPointsDice'])
			&& !is_numeric($data['baseHitPoints']) && !is_numeric($data['baseBreakFactor']) && !is_numeric($data['baseInitiative'])
			&& !$data['baseForceModificator'] && !is_numeric($data['weight']) && count($data['material']) === 0)
		{
			return false;
		}

		$moneyHelper = new \Helper\Money();
		$basePrice = $moneyHelper->exchange($data['basePrice'], $data['currency']);
		$baseForceModificators = \Helper\ForceModificator::getForceModificatorArray($data['baseForceModificator']);
		$materialForceModificatorString = '';

		if (!empty($data['materialForceModificator']))
		{
			foreach ($data['materialForceModificator'] as $materialForceModificator)
			{
				$materialForceModificatorString .= $materialForceModificator . ' || ';
			}
		}

		$materialForceModificators = \Helper\ForceModificator::getForceModificatorArray(substr($materialForceModificatorString, 0, -2));
		$upgradeForceModificator = \Helper\ForceModificator::toForceModificatorArray($data['upgradeForceModificator']['attack'], $data['upgradeForceModificator']['parade']);

		$sql = '
			INSERT INTO blueprints
			SET name = '.sqlval($data['name']).',
				itemTypeId = '.sqlval($data['itemTypeId']).',
				basePrice = '.sqlval($basePrice).',
				twoHanded = '.sqlval($data['twoHanded']).',
				improvisational = '.sqlval($data['improvisational']).',
				baseHitPointsDice = '.sqlval($data['baseHitPointsDice']).',
				baseHitPointsDiceType = '.sqlval($data['baseHitPointsDiceType']).',
				baseHitPoints = '.sqlval($data['baseHitPoints']).',
				baseBreakFactor = '.sqlval($data['baseBreakFactor']).',
				baseInitiative = '.sqlval($data['baseInitiative']).',
				baseForceModificator = '.sqlval(json_encode($baseForceModificators)).',
				weight = '.sqlval($data['weight']).',
				toolsProofModificator = '.sqlval($data['toolsProofModificator']).',
				planProofModificator = '.sqlval($data['planProofModificator']).',
				materialForceModificator = '.sqlval(json_encode($materialForceModificators)).',
				upgradeHitPoints = '.sqlval($data['upgradeHitPoints']).',
				upgradeBreakFactor = '.sqlval($data['upgradeBreakFactor']).',
				upgradeInitiative = '.sqlval($data['upgradeInitiative']).',
				upgradeForceModificator = '.sqlval(json_encode($upgradeForceModificator)).'
		';
		$blueprintId = query($sql);

		foreach ($data['material'] as $key => $material)
		{
			$sql = '
				INSERT INTO materialstoblueprints
				SET materialId = '.sqlval($material).',
					blueprintId = '.sqlval($blueprintId).',
					percentage = '.sqlval($data['percentage'][$key]).'
			';
			query($sql);
		}

		if (!empty($data['technique']))
		{
			foreach ($data['technique'] as $technique)
			{
				$sql = '
					INSERT INTO techniquestoblueprints
					SET techniqueId = '.sqlval($technique).',
						blueprintId = '.sqlval($blueprintId).'
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
			if ($key === 'itemTypeId')
			{
				$this->itemType = \Model\ItemType::loadById($value);
			}
			elseif ($key === 'twoHanded' || $key === 'improvisational')
			{
				$this->$key = boolval($value);
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
				percentage
			FROM materialstoblueprints
			WHERE `blueprintId` = '.sqlval($this->blueprintId).'
				AND !deleted
		';
		$materialIds = query($sql, true);

		$list = array();
		foreach ($materialIds as $material)
		{
			$list[$material['materialId']] = array(
				'material' => \Model\Material::loadById($material['materialId']),
				'percentage' => intval($material['percentage']),
			);
		}

		$this->materialList = $list;
	}

	public function loadTechniques()
	{
		$sql = '
			SELECT `techniqueId`
			FROM techniquestoblueprints
			WHERE `blueprintId` = '.sqlval($this->blueprintId).'
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

	public function getBasePrice()
	{
		return $this->basePrice;
	}

	public function getItemType()
	{
		return $this->itemType;
	}

	public function getTwoHanded()
	{
		return $this->twoHanded;
	}

	public function getImprovisational()
	{
		return $this->improvisational;
	}

	public function getBaseHitPointsDice()
	{
		return $this->baseHitPointsDice;
	}

	public function getBaseHitPointsDiceType()
	{
		return $this->baseHitPointsDiceType;
	}

	public function getBaseHitPoints()
	{
		return $this->baseHitPoints;
	}

	public function getBaseBreakFactor()
	{
		return $this->baseBreakFactor;
	}

	public function getBaseInitiative()
	{
		return $this->baseInitiative;
	}

	public function getBaseForceModificator()
	{
		return json_decode($this->baseForceModificator, true);
	}

	public function getWeight()
	{
		return $this->weight;
	}

	public function getToolsProofModificator()
	{
		return $this->toolsProofModificator;
	}

	public function getPlanProofModificator()
	{
		return $this->planProofModificator;
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

	public function getUpgradeForceModificator()
	{
		return json_decode($this->upgradeForceModificator, true);
	}

	public function getMaterialList()
	{
		return $this->materialList;
	}

	public function getTechniqueList()
	{
		return $this->techniqueList;
	}

	public function getEndPrice()
	{
		$price = $this->basePrice;
		$priceFactor = 0;
		$priceFactorBelowOne = 0;
		$moneyHelper = new \Helper\Money();

		foreach ($this->materialList as $item)
		{
			/* @var $material \Model\Material */
			$material = $item['material'];

			if ($material->getPriceFactor())
			{
				if ($material->getPriceFactor() >= 1)
				{
					$priceFactor += $material->getPriceFactor();
				}
				else
				{
					if (!$priceFactorBelowOne)
					{
						$priceFactorBelowOne = $material->getPriceFactor();
					}
					else
					{
						$priceFactorBelowOne *= $material->getPriceFactor();
					}
				}
			}
			elseif ($material->getPriceWeight())
			{
				$price += $this->weight * ($item['percentage'] / 100) * $material->getPriceWeight();
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

	public function getNotes()
	{
		$notes = '';

		if ($this->improvisational)
			$notes .= 'i ';

		if ($this->twoHanded)
			$notes .= 'z ';

		if ($this->upgradeInitiative || !empty($this->getUpgradeForceModificator()))
			$notes .= 'p';

		return trim($notes);
	}

	public function getResultingStats()
	{
		$translator = \Translator::getInstance();

		$time = $this->getItemType()->getTime();
		$hitPointsString = $this->getBaseHitPointsDice();
		$hitPointsString .= $translator->getTranslation($this->getBaseHitPointsDiceType());
		$hitPoints = $this->getBaseHitPoints();
		$breakFactor = $this->getBaseBreakFactor();
		$initiative = $this->getBaseInitiative();
		$forceModificatorList = array_merge(
			$this->getBaseForceModificator(),
			$this->getMaterialForceModificator(),
			$this->getUpgradeForceModificator()
		);

		foreach ($this->getMaterialList() as $item)
		{
			/* @var $material \Model\Material */
			$material = $item['material'];

			$time *= $material->getTimeFactor();
			$hitPoints += $material->getHitPoints();
			$breakFactor += $material->getBreakFactor();
		}

		/* @var $technique \Model\Technique */
		foreach ($this->getTechniqueList() as $technique)
		{
			$time *= $technique->getTimeFactor();
			$breakFactor += $technique->getBreakFactor();
			$hitPoints += $technique->getHitPoints();
		}

		$forceModificator = array(
			'attack' => 0,
			'parade' => 0,
		);

		foreach ($forceModificatorList as $forceMod)
		{
			$forceModificator['attack'] += $forceMod[0]['attack'];
			$forceModificator['parade'] += $forceMod[0]['parade'];
		}

		$hitPoints += $this->getUpgradeHitPoints();
		$initiative += $this->getUpgradeInitiative();
		$breakFactor += $this->getUpgradeBreakFactor();

		return array(
			'name' => $this->getName(),
			'hitPoints' => $hitPointsString.sprintf('%+d', $hitPoints),
			'weight' => $this->getWeight(),
			'breakFactor' => $breakFactor,
			'initiative' => $initiative,
			'price' => $this->getEndPrice(),
			'forceModificator' => vsprintf('%+d / %+d', $forceModificator),
			'notes' => $this->getNotes(),
			'time' => round($time).' '.$translator->getTranslation('tu'),
		);
	}

	public function remove()
	{
		$sql = '
			UPDATE blueprints
			SET deleted = 1
			WHERE `blueprintId` = '.sqlval($this->blueprintId).'
		';
		return query($sql);
	}
}
