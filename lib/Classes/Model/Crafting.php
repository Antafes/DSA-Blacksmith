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
 * Model class for a crafting.
 *
 * @package Model
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Crafting extends \SmartWork\Model
{
	/**
	 * @var integer
	 */
	protected $craftingId;

	/**
	 * @var \Model\Blueprint
	 */
	protected $blueprint;

	/**
	 * @var \Model\Character
	 */
	protected $character;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $notes;

	/**
	 * @var integer
	 */
	protected $toolsProofModificator;

	/**
	 * @var integer
	 */
	protected $planProofModificator;

	/**
	 * @var integer
	 */
	protected $gainedTalentPoints;

	/**
	 * @var boolean
	 */
	protected $done;

	/**
	 * A time unit in seconds
	 *
	 * @var integer
	 */
	protected $timeUnitSeconds = 7200;

	/**
	 * Load a crafting by its id.
	 *
	 * @param integer $id
	 *
	 * @return \self
	 */
	public static function loadById($id)
	{
		$sql = '
			SELECT
				`craftingId`,
				`blueprintId`,
				`characterId`,
				`name`,
				`notes`,
				`toolsProofModificator`,
				`planProofModificator`,
				`gainedTalentPoints`,
				`done`
			FROM craftings
			WHERE `craftingId` = '.\sqlval($id).'
				AND !deleted
		';
		$crafting = \query($sql);
		$obj = new self();
		$obj->fill($crafting);

		return $obj;
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
			if ($key === 'blueprintId')
			{
				$this->blueprint = \Model\Blueprint::loadById($value);
			}
			elseif ($key === 'characterId')
			{
				$this->character = \Model\Character::loadById($value);
			}
			elseif ($key === 'done')
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
	 * Create a new crafting from the given array.
	 * array(
	 *     'userId' => 1,
	 *     'blueprintId' => 1,
	 *     'characterId' => 1,
	 *     'name' => 'test',
	 *     'notes' => 'these are test notes',
	 *     'toolsProofModificator' => 0,
	 *     'planProofModificator' => 0,
	 *     'gainedTalentPoints' => 0,
	 * )
	 *
	 * @param string $data
	 *
	 * @return boolean
	 */
	public static function create($data)
	{
		$sql = '
			INSERT INTO craftings
			SET userId = '.\sqlval($data['userId']).',
				blueprintId = '.\sqlval($data['blueprintId']).',
				characterId = '.\sqlval($data['characterId']).',
				name = '.\sqlval($data['name']).',
				notes = '.\sqlval($data['notes']).',
				toolsProofModificator = '.\sqlval($data['toolsProofModificator']).',
				planProofModificator = '.\sqlval($data['planProofModificator']).',
				gainedTalentPoints = '.\sqlval($data['gainedTalentPoints']).'
		';
		\query($sql);

		return true;
	}

	/**
	 * Get the craftings properties as array
	 *
	 * @return array
	 */
	public function getAsArray()
	{
		return array(
			'craftingId' => $this->craftingId,
			'blueprint' => $this->blueprint,
			'character' => $this->character,
			'name' => $this->getName(),
			'notes' => $this->notes,
			'toolsProofModificator' => $this->getToolsProofModificator(),
			'planProofModificator' => $this->getPlanProofModificator(),
			'gainedTalentPoints' => $this->gainedTalentPoints,
			'totalTalentPoints' => $this->getTotalTalentPoints(),
			'handicap' => $this->getHandicap(),
			'estimatedFinishingTime' => $this->getEstimatedFinishingTime(),
			'done' => $this->done,
		);
	}

	/**
	 * Get the blueprint the crafting is based on.
	 *
	 * @return \Model\Blueprint
	 */
	public function getBlueprint()
	{
		return $this->blueprint;
	}

	/**
	 * Get the character that is crafting the item.
	 *
	 * @return \Model\Character
	 */
	public function getCharacter()
	{
		return $this->character;
	}

	/**
	 * Get the name for the crafting.
	 *
	 * @return string
	 */
	public function getName()
	{
		$name = $this->name;

		if (empty($name))
		{
			$name = $this->blueprint->getName();
		}

		return $name;
	}

	/**
	 * Get the multiline note for the crafting.
	 *
	 * @return string
	 */
	public function getNotes()
	{
		return $this->notes;
	}

	/**
	 * Get the proof modificator gained via the used tools.
	 *
	 * @return integer
	 */
	public function getToolsProofModificator()
	{
		return $this->toolsProofModificator;
	}

	/**
	 * Get the proof modificator gained via the made plan.
	 *
	 * @return integer
	 */
	public function getPlanProofModificator()
	{
		return $this->planProofModificator;
	}

	/**
	 * Get the total talent points which are already gained for this crafting.
	 *
	 * @return integer
	 */
	public function getGainedTalentPoints()
	{
		return $this->gainedTalentPoints;
	}

	/**
	 * Get whether the item is crafted or not.
	 *
	 * @return boolean
	 */
	public function getDone()
	{
		return $this->done;
	}

	/**
	 * Get the total amount of talent points which have to be gained for crafting this item.
	 *
	 * @return integer
	 */
	public function getTotalTalentPoints()
	{
		switch ($this->blueprint->getItemType()->getType()) {
			case 'weapon':
				$hitPoints = $this->blueprint->getEndHitPoints();
				$baseValue = $hitPoints['dices'] * 4 + $hitPoints['add'];
				$modificator = 3;
				$modificator += 0.5 * $this->blueprint->getUpgradeHitPoints();
				$modificator += 0.5 * $this->blueprint->getUpgradeBreakFactor() * -1;
				$modificator += 0.5 * $this->blueprint->getUpgradeInitiative();
				$weaponModificator = $this->blueprint->getUpgradeWeaponModificator();
				$modificator += 0.5 * ($weaponModificator[0]['attack'] + $weaponModificator[0]['parade']);
				break;
			case 'shield':
				break;
			case 'armor':
				break;
			case 'projectile':
				break;
		}

		return round($baseValue * $modificator);
	}

	/**
	 * Get the proof handicap.
	 *
	 * @return integer
	 */
	public function getHandicap()
	{
		$handicap = 0;
		$handicap += $this->blueprint->getUpgradeHitPoints() * 3;
		$handicap += $this->blueprint->getUpgradeBreakFactor() * -2;
		$handicap += $this->blueprint->getUpgradeInitiative() ? 5 : 0;
		$weaponModificator = $this->blueprint->getUpgradeWeaponModificator();
		$handicap += $weaponModificator[0]['attack'] ? 5 : 0;
		$handicap += $weaponModificator[0]['parade'] ? 5 : 0;

		foreach ($this->blueprint->getMaterialList() as $material)
		{
			/* @var $materialAsset \Model\MaterialAsset */
			$materialAsset = $material['materialAsset'];
			$handicap += $materialAsset->getProof();
		}

		/* @var $technique \Model\Technique */
		foreach ($this->blueprint->getTechniqueList() as $technique)
		{
			$handicap += $technique->getProof();
		}

		$handicap -= $this->getToolsProofModificator() + $this->getPlanProofModificator();

		return $handicap;
	}

	/**
	 * Get the estimated finishing time in days or hours.
	 *
	 * @return string
	 */
	public function getEstimatedFinishingTime()
	{
		if ($this->done)
		{
			return '-';
		}

		$talentPoints = $this->getTotalTalentPoints() - $this->getGainedTalentPoints();
		$charHandicap = $this->character->getBlacksmith() - $this->getHandicap();

		if ($charHandicap <= 0)
		{
			$charHandicap = 1;
		}

		$time = ($talentPoints / $charHandicap) * ($this->blueprint->getTimeUnits() * $this->timeUnitSeconds);

		if ($time < 28800)
		{
			return \Helper\Formatter::time($time);
		}
		else
		{
			return round($time / (8 * 3600)).' '.  \SmartWork\Translator::getInstance()->gt('days');
		}
	}

	/**
	 * Add gained talent points.
	 *
	 * @param integer $talentPoints
	 */
	public function addTalentPoints($talentPoints)
	{
		$sql = '
			UPDATE craftings
			SET `gainedTalentPoints` = `gainedTalentPoints` + '.\sqlval($talentPoints).'
			WHERE `craftingId` = '.\sqlval($this->craftingId).'
		';
		\query($sql);

		$this->gainedTalentPoints += $talentPoints;
	}

	/**
	 * Mark the crafting as done.
	 *
	 * @return void
	 */
	public function done()
	{
		$sql = '
			UPDATE craftings
			SET done = 1
			WHERE `craftingId` = '.\sqlval($this->craftingId).'
		';
		\query($sql);
	}

	/**
	 * Remove the crafting.
	 *
	 * @return void
	 */
	public function remove()
	{
		$sql = '
			UPDATE craftings
			SET deleted = 1
			WHERE `craftingId` = '.\sqlval($this->craftingId).'
		';
		\query($sql);
	}
}
