<?php
namespace Model;
/**
 * Description of Crafting
 *
 * @author Neithan
 */
class Crafting extends \Model
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

	public function getAsArray()
	{
		return array(
			'craftingId' => $this->craftingId,
			'blueprint' => $this->blueprint,
			'character' => $this->character,
			'name' => $this->name,
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

	public function getBlueprint()
	{
		return $this->blueprint;
	}

	public function getCharacter()
	{
		return $this->character;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getNotes()
	{
		return $this->notes;
	}

	public function getToolsProofModificator()
	{
		return $this->toolsProofModificator;
	}

	public function getPlanProofModificator()
	{
		return $this->planProofModificator;
	}

	public function getGainedTalentPoints()
	{
		return $this->gainedTalentPoints;
	}

	public function getDone()
	{
		return $this->done;
	}

	/**
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
				$forceModificator = $this->blueprint->getUpgradeForceModificator();
				$modificator += 0.5 * ($forceModificator[0]['attack'] + $forceModificator[0]['parade']);
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
	 * @return integer
	 */
	public function getHandicap()
	{
		$handicap = 0;
		$handicap += $this->blueprint->getUpgradeHitPoints() * 3;
		$handicap += $this->blueprint->getUpgradeBreakFactor() * -2;
		$handicap += $this->blueprint->getUpgradeInitiative() ? 5 : 0;
		$forceModificator = $this->blueprint->getUpgradeForceModificator();
		$handicap += $forceModificator[0]['attack'] ? 5 : 0;
		$handicap += $forceModificator[0]['parade'] ? 5 : 0;

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
			return round($time / (8 * 3600)).' '.\Translator::getInstance()->getTranslation('days');
		}
	}

	/**
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

	public function done()
	{
		$sql = '
			UPDATE craftings
			SET done = 1
			WHERE `craftingId` = '.\sqlval($this->craftingId).'
		';
		\query($sql);
	}

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
