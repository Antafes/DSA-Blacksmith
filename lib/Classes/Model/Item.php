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
 * Model class for Items.
 *
 * @package Model
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Item extends \SmartWork\Model
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
	 * @var string
	 */
	protected $itemType;

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
	 * Only used for ranged weapons
	 *
	 * @var integer
	 */
	protected $physicalStrengthRequirement;

	/**
	 * Load an item by its id.
	 *
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
				`itemType`,
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
				`weight`,
				`physicalStrengthRequirement`
			FROM items
			WHERE `itemId` = '.\sqlval($id).'
				AND !deleted
		';
		$item = query($sql);
		$obj = new self();

		$obj->fill($item);

		return $obj;
	}

	/**
	 * Create a new item from the given array.
	 * array(
	 *     'name' => 'test',
	 *     'price' => 100,
	 *     'currency' => 'S',
	 *     'twoHanded' => 1, // may be 1 or 0
	 *     'improvisational' => 1, // may be 1 or 0
	 *     'privileged' => 1, // may be 1 or 0
	 *     'hitPointsDice' => 2,
	 *     'hitPointsDiceType' => 'd6',
	 *     'hitPoints' => 2,
	 *     'damageType' => 'damage',
	 *     'breakFactor' => 1,
	 *     'initiative' => -1,
	 *     'weaponModificator' => '0/-1',
	 *     'weight' => 150,
	 * )
	 *
	 * @param array $data
	 *
	 * @return boolean
	 */
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
				itemType = '.\sqlval($data['itemType']).',
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
				weight = '.\sqlval($data['weight']).',
				physicalStrengthRequirement = '.\sqlval($data['physicalStrengthRequirement']).'
		';
		query($sql);

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

	/**
	 * Get the items id.
	 *
	 * @return integer
	 */
	public function getItemId()
	{
		return $this->itemId;
	}

	/**
	 * Get the items name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the items type. May be one of the following:
	 * - meleeWeapon
	 * - rangedWeapon
	 * - shield
	 * - armor
	 * - projectile
	 *
	 * @return string
	 */
	public function getItemType()
	{
		return $this->itemType;
	}

	/**
	 * Get the price in Kreuzer.
	 *
	 * @return integer
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * Get the price formatted as Silbertaler.
	 *
	 * @return string
	 */
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

	/**
	 * If the item is two handed or not.
	 *
	 * @return boolean
	 */
	public function getTwoHanded()
	{
		return $this->twoHanded;
	}

	/**
	 * If the item is an improvisational weapon.
	 *
	 * @return boolean
	 */
	public function getImprovisational()
	{
		return $this->improvisational;
	}

	/**
	 * If the item is only available for privileged people.
	 *
	 * @return boolean
	 */
	public function getPrivileged()
	{
		return $this->privileged;
	}

	/**
	 * Get the amount of dice.
	 *
	 * @return integer
	 */
	public function getHitPointsDice()
	{
		return $this->hitPointsDice;
	}

	/**
	 * Get the dice type.
	 *
	 * @return string
	 */
	public function getHitPointsDiceType()
	{
		return $this->hitPointsDiceType;
	}

	/**
	 * Get the hit points after the dice.
	 *
	 * @return integer
	 */
	public function getHitPoints()
	{
		return $this->hitPoints;
	}

	/**
	 * Get a formatted string for the hit points, i.e. 1D6+1.
	 *
	 * @return string
	 */
	public function getHitPointsString()
	{
		return \Helper\HitPoints::getHitPointsString(array(
			'hitPointsDice' => $this->getHitPointsDice(),
			'hitPointsDiceType' => $this->getHitPointsDiceType(),
			'hitPoints' => $this->getHitPoints(),
			'damageType' => $this->getDamageType(),
		));
	}

	/**
	 * Get the damage type of the item. May be on of 'damage' or 'stamina'.
	 *
	 * @return string
	 */
	public function getDamageType()
	{
		return $this->damageType;
	}

	/**
	 * Get the break factor of the item.
	 *
	 * @return integer
	 */
	public function getBreakFactor()
	{
		return $this->breakFactor;
	}

	/**
	 * Get the initiative modificator of the item.
	 *
	 * @return integer
	 */
	public function getInitiative()
	{
		return $this->initiative;
	}

	/**
	 * Get the weapon modificator.
	 *
	 * @return array
	 */
	public function getWeaponModificator()
	{
		return json_decode($this->weaponModificator, true);
	}

	/**
	 * Get the weapon modificator string, i.e. 0/-1
	 *
	 * @return string
	 */
	public function getWeaponModificatorFormatted()
	{
		$weaponModificator = $this->getWeaponModificator();
		return \Helper\WeaponModificator::format($weaponModificator[0]);
	}

	/**
	 * Get the weight in ounzes.
	 *
	 * @return integer
	 */
	public function getWeight()
	{
		return $this->weight;
	}

	/**
	 * Get the physical strength requirement.
	 * Only used for ranged weapons.
	 *
	 * @return integer
	 */
	public function physicalStrengthRequirement()
	{
		return $this->physicalStrengthRequirement;
	}

	/**
	 * Remove the item.
	 *
	 * @return void
	 */
	public function remove()
	{
		$sql = '
			UPDATE items
			SET deleted = 1
			WHERE `itemId` = '.\sqlval($this->itemId).'
		';
		\query($sql);
	}

	/**
	 * Get the properties of the item as an array.
	 *
	 * @return array
	 */
	public function getAsArray()
	{
		return array(
			'itemId' => $this->getItemId(),
			'name' => $this->getName(),
			'price' => $this->getPrice(),
			'priceFormatted' => $this->getPriceFormatted(),
			'twoHanded' => $this->getTwoHanded(),
			'improvisational' => $this->getImprovisational(),
			'privileged' => $this->getPrivileged(),
			'hitPointsDice' => $this->getHitPointsDice(),
			'hitPointsDiceType' => $this->getHitPointsDiceType(),
			'hitPoints' => $this->getHitPoints(),
			'hitPointsString' => $this->getHitPointsString(),
			'damageType' => $this->getDamageType(),
			'breakFactor' => $this->getBreakFactor(),
			'initiative' => $this->getInitiative(),
			'weaponModificator' => $this->getWeaponModificator(),
			'weaponModificatorFormatted' => $this->getWeaponModificatorFormatted(),
			'weight' => $this->getWeight(),
			'notes' => $this->getNotes(),
			'physicalStrengthRequirement' => $this->physicalStrengthRequirement(),
		);
	}

	/**
	 * Get the notes for the item. May consist of any or all of the following:
	 * - 'i' for improvisational
	 * - 'z' for two handed
	 * - 'p' for privileged
	 *
	 * @return string
	 */
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
