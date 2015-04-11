<?php
namespace Model;

/**
 * Description of Item
 *
 * @author Neithan
 */
class Item extends \Model
{
	/**
	 * @var integer
	 */
	protected $itemId;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var integer
	 */
	protected $price;

	/**
	 * @var boolean
	 */
	protected $twoHanded;

	/**
	 * @var boolean
	 */
	protected $improvisational;

	/**
	 * @var boolean
	 */
	protected $privileged;

	/**
	 * @var integer
	 */
	protected $hitPointsDice;

	/**
	 * @var string
	 */
	protected $hitPointsDiceType;

	/**
	 * @var integer
	 */
	protected $hitPoints;

	/**
	 * @var string
	 */
	protected $damageType;

	/**
	 * @var integer
	 */
	protected $breakFactor;

	/**
	 * @var integer
	 */
	protected $initiative;

	/**
	 * @var string
	 */
	protected $weaponModificator;

	/**
	 * @var integer
	 */
	protected $weight;

	/**
	 * @param integer $id
	 *
	 * @return \self
	 */
	public static function loadById($id)
	{
		$sql = '
			SELECT
				`itemId`,
				`name`,
				`price`,
				`twoHanded`,
				`improvisational`,
				`privileged`,
				`hitPointsDice`,
				`hitPointsDiceType`,
				`hitPoints`,
				`damageType`,
				`breakFactor`,
				`initiative`,
				`weaponModificator`,
				`weight`
			FROM items
			WHERE `itemId` = '.\sqlval($id).'
				AND !deleted
		';
		$item = query($sql);
		$obj = new self();

		$obj->fill($item);

		return $obj;
	}

	public static function create($data)
	{
		if (!$data['name'] && !isset($data['price']) && !$data['hitPointsDice']
			&& !$data['hitPointsDiceType'] && !$data['weight'])
			return false;

		$moneyHelper = new \Helper\Money();
		$price = $moneyHelper->exchange($data['price'], $data['currency']);
		$weaponModificator = \Helper\WeaponModificator::getWeaponModificatorArray($data['weaponModificator']);

		$sql = '
			INSERT INTO items
			SET name = '.\sqlval($data['name']).',
				price = '.\sqlval($price).',
				twoHanded = '.\sqlval($data['twoHanded']).',
				improvisational = '.\sqlval($data['improvisational']).',
				privileged = '.\sqlval($data['privileged']).',
				hitPointsDice = '.\sqlval($data['hitPointsDice']).',
				hitPointsDiceType = '.\sqlval($data['hitPointsDiceType']).',
				hitPoints = '.\sqlval($data['hitPoints']).',
				damageType = '.\sqlval($data['damageType']).',
				breakFactor = '.\sqlval($data['breakFactor']).',
				initiative = '.\sqlval($data['initiative']).',
				weaponModificator = '.\sqlval(json_encode($weaponModificator)).',
				weight = '.\sqlval($data['weight']).'
		';
		query($sql);

		return true;
	}

	public function fill($data)
	{
		foreach ($data as $key => $value)
		{
			if ($key === 'twoHanded' || $key === 'improvisational' || $key === 'privileged')
			{
				$this->$key = (bool) $value;
			}
			elseif (property_exists($this, $key))
			{
				$this->$key = $this->castToType($value);
			}
		}
	}

	public function getItemId()
	{
		return $this->itemId;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function getPriceFormatted()
	{
		$moneyHelper = new \Helper\Money();
		$price = $moneyHelper->exchange($this->getPrice(), 'K', 'S');

		if ($price > 0 && $price < 1)
		{
			return number_format($price, 1, ',', '.') . ' S';
		}
		else
		{
			return number_format($price, 0, ',', '.') . ' S';
		}
	}

	public function getTwoHanded()
	{
		return $this->twoHanded;
	}

	public function getImprovisational()
	{
		return $this->improvisational;
	}

	public function getPrivileged()
	{
		return $this->privileged;
	}

	public function getHitPointsDice()
	{
		return $this->hitPointsDice;
	}

	public function getHitPointsDiceType()
	{
		return $this->hitPointsDiceType;
	}

	public function getHitPoints()
	{
		return $this->hitPoints;
	}

	public function getHitPointsString()
	{
		return \Helper\HitPoints::getHitPointsString(array(
			'hitPointsDice' => $this->getHitPointsDice(),
			'hitPointsDiceType' => $this->getHitPointsDiceType(),
			'hitPoints' => $this->getHitPoints(),
			'damageType' => $this->getDamageType(),
		));
	}

	public function getDamageType()
	{
		return $this->damageType;
	}

	public function getBreakFactor()
	{
		return $this->breakFactor;
	}

	public function getInitiative()
	{
		return $this->initiative;
	}

	public function getWeaponModificator()
	{
		return json_decode($this->weaponModificator, true);
	}

	public function getWeaponModificatorFormatted()
	{
		$weaponModificator = $this->getWeaponModificator();
		return \Helper\WeaponModificator::format($weaponModificator[0]);
	}

	public function getWeight()
	{
		return $this->weight;
	}

	public function remove()
	{
		$sql = '
			UPDATE items
			SET deleted = 1
			WHERE `itemId` = '.\sqlval($this->itemId).'
		';
		return query($sql);
	}

	public function getAsArray()
	{
		return array(
			'itemId' => $this->getItemId(),
			'name' => $this->getName(),
			'price' => $this->getPrice(),
			'twoHanded' => $this->getTwoHanded(),
			'improvisational' => $this->getImprovisational(),
			'privileged' => $this->getPrivileged(),
			'hitPointsDice' => $this->getHitPointsDice(),
			'hitPointsDiceType' => $this->getHitPointsDiceType(),
			'hitPoints' => $this->getHitPoints(),
			'damageType' => $this->getDamageType(),
			'breakFactor' => $this->getBreakFactor(),
			'initiative' => $this->getInitiative(),
			'weaponModificator' => $this->getWeaponModificator(),
			'weight' => $this->getWeight(),
		);
	}

	public function getNotes()
	{
		$notes = '';

		if ($this->improvisational)
			$notes .= 'i ';

		if ($this->twoHanded)
			$notes .= 'z ';

		if ($this->privileged)
			$notes .= 'p';

		return trim($notes);
	}
}
