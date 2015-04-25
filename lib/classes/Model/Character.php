<?php
namespace Model;

/**
 * Description of Character
 *
 * @author Neithan
 */
class Character extends \SmartWork\Model
{
	/**
	 * @var integer
	 */
	protected $characterId;

	/**
	 * @var string
	 */
	protected $key;

	/**
	 * @var \DateTime
	 */
	protected $lastUpdate;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var integer
	 */
	protected $bowMaking;

	/**
	 * @var integer
	 */
	protected $precisionMechanics;

	/**
	 * @var integer
	 */
	protected $blacksmith;

	/**
	 * @var integer
	 */
	protected $woodworking;

	/**
	 * @var integer
	 */
	protected $leatherworking;

	/**
	 * @var integer
	 */
	protected $tailoring;

	/**
	 *
	 * @param integer $id
	 *
	 * @return \self
	 */
	public static function loadById($id)
	{
		$sql = '
			SELECT
				`characterId`,
				`key`,
				`lastUpdate`,
				`name`,
				`bowMaking`,
				`precisionMechanics`,
				blacksmith,
				woodworking,
				leatherworking,
				tailoring
			FROM characters
			WHERE `characterId` = '.sqlval($id).'
				AND !deleted
		';
		$character = query($sql);
		$obj = new self();
		$obj->fill($character);

		return $obj;
	}

	/**
	 * @param array $data
	 */
	public function fill($data)
	{
		foreach ($data as $key => $value)
		{
			if ($key === 'lastUpdate')
			{
				$this->lastUpdate = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
			}
			elseif (property_exists($this, $key))
			{
				$this->$key = $this->castToType($value);
			}
		}
	}

	/**
	 * @return array
	 */
	public function getAsArray()
	{
		return array(
			'characterId' => $this->characterId,
			'key' => $this->key,
			'lastUpdate' => $this->lastUpdate,
			'name' => $this->name,
			'bowMaking' => $this->bowMaking,
			'precisionMechanics' => $this->precisionMechanics,
			'blacksmith' => $this->blacksmith,
			'woodworking' => $this->woodworking,
			'leatherworking' => $this->leatherworking,
			'tailoring' => $this->tailoring,
		);
	}

	/**
	 * @param array $data
	 *
	 * @return boolean
	 */
	public static function create($data)
	{
		if (!is_object($data['user']) && !$data['key'] && !$data['name']
			&& !is_numeric($data['bowMaking']) && !is_numeric($data['precisionMechanics'])
			&& !is_numeric($data['blacksmith']) && !is_numeric($data['woodworking'])
			&& !is_numeric($data['leatherworking']) && !is_numeric($data['tailoring']))
		{
			return false;
		}

		$sql = '
			INSERT INTO characters
			SET userId = '.sqlval($data['user']->getUserId()).',
				`key` = '.sqlval($data['key']).',
				`lastUpdate` = '.sqlval($data['lastUpdate']->format('Y-m-d H:i:s')).',
				`name` = '.sqlval($data['name']).',
				bowMaking = '.sqlval($data['bowMaking']).',
				precisionMechanics = '.sqlval($data['precisionMechanics']).',
				blacksmith = '.sqlval($data['blacksmith']).',
				woodworking = '.sqlval($data['woodworking']).',
				leatherworking = '.sqlval($data['leatherworking']).',
				tailoring = '.sqlval($data['tailoring']).'
			ON DUPLICATE KEY UPDATE
				`lastUpdate` = '.sqlval($data['lastUpdate']->format('Y-m-d H:i:s')).',
				bowMaking = '.sqlval($data['bowMaking']).',
				precisionMechanics = '.sqlval($data['precisionMechanics']).',
				blacksmith = '.sqlval($data['blacksmith']).',
				woodworking = '.sqlval($data['woodworking']).',
				leatherworking = '.sqlval($data['leatherworking']).',
				tailoring = '.sqlval($data['tailoring']).'
		';
		query($sql);

		return true;
	}

	public function remove()
	{
		$sql = '
			UPDATE characters
			SET deleted = 1
			WHERE `characterId` = '.sqlval($this->characterId).'
		';
		query($sql);
	}

	public function getCharacterId()
	{
		return $this->characterId;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function getLastUpdate()
	{
		return $this->lastUpdate;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getBowMaking()
	{
		return $this->bowMaking;
	}

	public function getPrecisionMechanics()
	{
		return $this->precisionMechanics;
	}

	public function getBlacksmith()
	{
		return $this->blacksmith;
	}

	public function getWoodworking()
	{
		return $this->woodworking;
	}

	public function getLeatherworking()
	{
		return $this->leatherworking;
	}

	public function getTailoring()
	{
		return $this->tailoring;
	}
}
