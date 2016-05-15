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
 * Model class for the material assets.
 *
 * @package Model
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class MaterialAsset extends \SmartWork\Model
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
	protected $weaponModificator;

	/**
	 * Load a material asset by its id.
	 *
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
				`weaponModificator`
			FROM materialAssets
			WHERE `materialAssetId` = '.\sqlval($id).'
				AND !deleted
		';
		$materialAsset = query($sql);
		$obj = new self();
		$obj->fill($materialAsset);

		return $obj;
	}

	/**
	 * Create a new material asset from the given array.
	 * array(
	 *     'percentage' => array(
	 *         0 => 50,
	 *         1 => 50,
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
		if (!$data['materialId'] && !$data['percentage'] && !$data['timeFactor'] && (!$data['priceFactor'] || $data['priceWeight']))
		{
			return false;
		}

		$weaponModificators = array();
		if (!empty($data['weaponModificator']))
		{
			$weaponModificators = \Helper\WeaponModificator::getWeaponModificatorArray($data['weaponModificator']);
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
				weaponModificator = '.\sqlval(json_encode($weaponModificators)).'
		';
		query($sql);

		return true;
	}

	/**
	 * Create a new material asset from the given array.
	 * array(
	 *     'percentage' => array(
	 *         0 => 50,
	 *         1 => 50,
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
		$weaponModificators = array();
		if (!empty($data['weaponModificator']))
		{
			$weaponModificators = \Helper\WeaponModificator::getWeaponModificatorArray($data['weaponModificator']);
		}

		if (!empty($data['priceWeight']))
		{
			$moneyHelper = new \Helper\Money();
			$data['priceWeight'] = $moneyHelper->exchange($data['priceWeight'], $data['currency']);
		}

		$sql = '
			UPDATE materialAssets
			SET percentage = '.\sqlval($data['percentage']).',
				timeFactor = '.\sqlval($data['timeFactor']).',
				priceFactor = '.\sqlval($data['priceFactor']).',
				priceWeight = '.\sqlval($data['priceWeight']).',
				proof = '.\sqlval($data['proof']).',
				breakFactor = '.\sqlval($data['breakFactor']).',
				hitPoints = '.\sqlval($data['hitPoints']).',
				armor = '.\sqlval($data['armor']).',
				weaponModificator = '.\sqlval(json_encode($weaponModificators)).'
            WHERE `materialAssetId` = '.\sqlval($this->getMaterialAssetId()).'
		';
		query($sql);

		return true;
	}

	/**
	 * Get the material asset id.
	 *
	 * @return integer
	 */
	public function getMaterialAssetId()
	{
		return $this->materialAssetId;
	}

	/**
	 * Get the percentage at which this asset will be used.
	 *
	 * @return integer
	 */
	public function getPercentage()
	{
		return $this->percentage;
	}

	/**
	 * Get the time factor that this asset will add to the production time.
	 *
	 * @return float
	 */
	public function getTimeFactor()
	{
		return $this->timeFactor;
	}

	/**
	 * Get the price factor that this asset will add to the total price.
	 *
	 * @return float
	 */
	public function getPriceFactor()
	{
		return $this->priceFactor;
	}

	/**
	 * Get the weight price as a formatted string.
	 *
	 * @return string
	 */
	public function getPriceWeight()
	{
		$moneyHelper = new \Helper\Money();

		return number_format($moneyHelper->exchange($this->priceWeight, 'K', 'S'), 0, ',', '.').' ST';
	}

	/**
	 * Get the weight price in Kreuzers.
	 *
	 * @return integer
	 */
	public function getPriceWeightRaw()
	{
		return $this->priceWeight;
	}

	/**
	 * Get the proof modificator.
	 *
	 * @return integer
	 */
	public function getProof()
	{
		return $this->proof;
	}

	/**
	 * Get the break factor modificator.
	 *
	 * @return integer
	 */
	public function getBreakFactor()
	{
		return $this->breakFactor;
	}

	/**
	 * Get the hit points modificator.
	 *
	 * @return integer
	 */
	public function getHitPoints()
	{
		return $this->hitPoints;
	}

	/**
	 * Get the armor modificator.
	 *
	 * @return integer
	 */
	public function getArmor()
	{
		return $this->armor;
	}

	/**
	 * Get the weapon modificators.
	 *
	 * @return array
	 */
	public function getWeaponModificator()
	{
		return json_decode($this->weaponModificator, true);
	}

	/**
	 * Get the objects properties as an array.
	 *
	 * @return array
	 */
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
			'weaponModificator' => $this->getWeaponModificator(),
		);
	}
}
