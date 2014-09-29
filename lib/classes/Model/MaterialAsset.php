<?php
namespace Model;

/**
 * Description of MaterialAsset
 *
 * @author Neithan
 */
class MaterialAsset extends \Model
{
	/**
	 * @var integer
	 */
	protected $materialAssetId;

	/**
	 * @var integer
	 */
	protected $percentage;

	/**
	 * @var float
	 */
	protected $timeFactor;

	/**
	 * @var float
	 */
	protected $priceFactor;

	/**
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
	 * @param integer $id
	 *
	 * @return \self
	 */
	public static function loadById($id)
	{
		$sql = '
			SELECT
				`materialAssetId`,
				percentage,
				`timeFactor`,
				`priceFactor`,
				`priceWeight`,
				proof,
				`breakFactor`,
				`hitPoints`,
				armor,
				`forceModificator`
			FROM materialAssets
			WHERE `materialAssetId` = '.\sqlval($id).'
				AND !deleted
		';
		$materialAsset = query($sql);
		$obj = new self();
		$obj->fill($materialAsset);

		return $obj;
	}

	public static function create($data)
	{
		if (!$data['materialId'] && !$data['percentage'] && !$data['timeFactor'] && (!$data['priceFactor'] || $data['priceWeight']))
		{
			return false;
		}

		$forceModificators = array();
		if (!empty($data['forceModificator']))
		{
			$forceModificators = \Helper\ForceModificator::getForceModificatorArray($data['forceModificator']);
		}

		if (!empty($data['priceWeight']))
		{
			$moneyHelper = new \Helper\Money();
			$data['priceWeight'] = $moneyHelper->exchange($data['priceWeight'], $data['currency']);
		}

		$sql = '
			INSERT INTO materialAssets
			SET materialId = '.\sqlval($data['materialId']).',
				percentage = '.\sqlval($data['percentage']).',
				timeFactor = '.\sqlval($data['timeFactor']).',
				priceFactor = '.\sqlval($data['priceFactor']).',
				priceWeight = '.\sqlval($data['priceWeight']).',
				proof = '.\sqlval($data['proof']).',
				breakFactor = '.\sqlval($data['breakFactor']).',
				hitPoints = '.\sqlval($data['hitPoints']).',
				armor = '.\sqlval($data['armor']).',
				forceModificator = '.\sqlval(json_encode($forceModificators)).'
		';
		query($sql);

		return true;
	}

	public function getMaterialAssetId()
	{
		return $this->materialAssetId;
	}

	public function getPercentage()
	{
		return $this->percentage;
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
		$moneyHelper = new \Helper\Money();

		return number_format($moneyHelper->exchange($this->priceWeight, 'K', 'S'), 0, ',', '.').' ST';
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

	public function getAsArray()
	{
		return array(
			'materialAssetId' => $this->getMaterialAssetId(),
			'percentage' => $this->getPercentage(),
			'timeFactor' => $this->getTimeFactor(),
			'priceFactor' => $this->getPriceFactor(),
			'priceWeight' => $this->getPriceWeight(),
			'proof' => $this->getProof(),
			'breakFactor' => $this->getBreakFactor(),
			'hitPoints' => $this->getHitPoints(),
			'armor' => $this->getArmor(),
			'forceModificator' => $this->getForceModificator(),
		);
	}
}
