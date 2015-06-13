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
	 * An array of the gained talent points, sorted by talent
	 *
	 * @var array
	 */
	protected $gainedTalentPoints = array();

	/**
	 * The amount of done proofs.
	 *
	 * @var integer
	 */
	protected $doneProofs;

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
				`doneProofs`,
				`done`
			FROM craftings
			WHERE `craftingId` = '.\sqlval($id).'
				AND !deleted
		';
		$crafting = \query($sql);
		$obj = new self();
		$obj->fill($crafting);
		$obj->loadTalentPoints();

		return $obj;
	}

	/**
	 * Load the gained talent points for each talent used in this crafting.
	 *
	 * @return void
	 */
	public function loadTalentPoints()
	{
		$materialIds = array();
		foreach ($this->getBlueprint()->getMaterialList() as $material)
		{
			$materialIds[] = $material['material']->getMaterialId();
		}

		$sql = '
			SELECT
				SUM(ctp.`gainedTalentPoints`) AS gainedTalentPoints,
				m2b.talent,
				m2b.percentage
			FROM craftingTalentPoints AS ctp
			JOIN materialsToBlueprints AS m2b ON (
				ctp.`blueprintId` = m2b.`blueprintId` AND ctp.materialid = m2b.`materialId`
			)
			WHERE ctp.`craftingId` = '.\sqlval($this->craftingId).'
				AND ctp.materialid IN ('.implode(',', \sqlval($materialIds)).')
				AND ctp.`blueprintId` = '.\sqlval($this->getBlueprint()->getBlueprintId()).'
			GROUP BY m2b.talent
		';
		$data = \query($sql, true);

		foreach ($data as $row)
		{
			$this->gainedTalentPoints[$row['talent']] = intval($row['gainedTalentPoints']);
		}
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
				planProofModificator = '.\sqlval($data['planProofModificator']).'
		';
		$craftingId = \query($sql);

		$sql = '
			SELECT
				`blueprintId`,
				`materialId`
			FROM materialsToBlueprints
			WHERE `blueprintId` = '.\sqlval($data['blueprintId']).'
		';
		$data = \query($sql, true);

		foreach ($data as $row)
		{
			$sql = '
				INSERT INTO craftingTalentPoints
				SET craftingId = '.\sqlval($craftingId).',
					materialId = '.\sqlval($row['materialId']).',
					blueprintId = '.\sqlval($row['blueprintId']).'
			';
			\query($sql);
		}

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
			'totalGainedTalentPoints' => $this->getTotalGainedTalentPoints(),
			'totalTalentPoints' => $this->getTotalTalentPoints(),
			'totalTalentPointsInfo' => $this->getTotalTalentPointsInfo(),
			'talentPointsInfo' => $this->getTalentPointsInfo(),
			'gainedTalentPointsInfo' => $this->getGainedTalentPointsInfo(),
			'handicap' => $this->getHandicap(),
			'estimatedFinishingTime' => $this->getEstimatedFinishingTime(),
			'productionTime' => $this->getProductionTime(),
			'done' => $this->done,
			'talents' => $this->getTalents(),
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
	 * Get an array with the total talent points which are already gained for this crafting.
	 *
	 * @return array
	 */
	public function getGainedTalentPoints()
	{
		return $this->gainedTalentPoints;
	}

	/**
	 * Get the gained talent points in total.
	 *
	 * @return integer
	 */
	public function getTotalGainedTalentPoints()
	{
		return array_sum($this->getGainedTalentPoints());
	}

	/**
	 * Get an array with the calculated talent points per talent.
	 *
	 * @return array
	 */
	protected function calculateTalentPoints()
	{
		$talentPointList = array();
		$totalTalentPoints = $this->getTotalTalentPoints();
		$materialList = $this->getBlueprint()->getMaterialList();
		$isFirst = true;

		foreach ($this->getGainedTalentPoints() as $talent => $talentPoints)
		{
			$currentTalentPoints = 0;
			foreach ($materialList as $material)
			{
				if ($material['talent'] == $talent)
				{
					if ($isFirst)
					{
						$currentTalentPoints += ceil($totalTalentPoints * ($material['percentage'] / 100));
						$isFirst = false;
					}
					else
					{
						$currentTalentPoints += floor($totalTalentPoints * ($material['percentage'] / 100));
					}
				}
			}

			$talentPointList[$talent] = $currentTalentPoints;
		}

		return $talentPointList;
	}

	/**
	 * Get the talent points info.
	 *
	 * @return string
	 */
	public function getTalentPointsInfo()
	{
		$translator = \SmartWork\Translator::getInstance();
		$calculatedTalentPoints = $this->calculateTalentPoints();
		$info = '';

		foreach ($this->getGainedTalentPoints() as $talent => $talentPoints)
		{
			$info .= $translator->gt($talent).': ';
			$currentTalentPoints = $calculatedTalentPoints[$talent];
			$info .= ($currentTalentPoints - $talentPoints).' ('.$currentTalentPoints.')'."\n";
		}

		return $info;
	}

	/**
	 * Get the gained talent points info.
	 *
	 * @return string
	 */
	public function getGainedTalentPointsInfo()
	{
		$translator = \SmartWork\Translator::getInstance();
		$info = '';

		foreach ($this->getGainedTalentPoints() as $talent => $talentPoints)
		{
			$info .= $translator->gt($talent).': '.$talentPoints."\n";
		}

		return $info;
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

	public function getTotalTalentPointsInfo()
	{
		$gainedTalentPoints = $this->getGainedTalentPoints();
		$talentPoints = $this->calculateTalentPoints();
		$neededTalentPoints = $this->getTotalTalentPoints();
		$remainingTalentPoints = 0;

		foreach ($talentPoints as $talent => $points)
		{
			$currentTalentPoints = $points - $gainedTalentPoints[$talent];

			if ($currentTalentPoints < 0)
			{
				$currentTalentPoints = 0;
			}

			$remainingTalentPoints += $currentTalentPoints;
		}

		return $remainingTalentPoints.' ('.$neededTalentPoints.')';
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
	 * @param boolean $format
	 *
	 * @return string|integer
	 */
	public function getEstimatedFinishingTime($format = true)
	{
		$talentPoints = $this->getTotalTalentPoints();
		$charHandicap = $this->character->getBlacksmith() - $this->getHandicap();

		if ($charHandicap <= 0)
		{
			$charHandicap = 1;
		}

		$time = ($talentPoints / $charHandicap) * ($this->blueprint->getTimeUnits() * $this->timeUnitSeconds);

		if ($format) {
			return $this->formatProductionTime($time);
		}

		return $time;
	}

	/**
	 * Get the time already used for producing this item.
	 *
	 * @param boolean $format
	 *
	 * @return string|integer
	 */
	public function getCurrentProductionTime($format = true)
	{
		$time = $this->doneProofs * ($this->blueprint->getTimeUnits() * $this->timeUnitSeconds);

		if ($format) {
			return $this->formatProductionTime($time);
		}

		return $time;
	}

	/**
	 * Get the current and the estimated production time as a formatted string
	 *
	 * @return string
	 */
	public function getProductionTime()
	{
		$estimatedTime = $this->getEstimatedFinishingTime(false);
		$currentTime = $this->getCurrentProductionTime(false);
		$time = '';

		if ($currentTime && $currentTime < 28800)
		{
			$time .= \Helper\Formatter::time($currentTime);
		}
		else
		{
			$time .= round($currentTime / (8 * 3600));
		}

		$time .= ' / ';
		$time .= $this->formatProductionTime($estimatedTime);

		return $time;
	}

	/**
	 * Formats the seconds needed for production to a time or days string.
	 *
	 * @param integer $time
	 *
	 * @return string
	 */
	protected function formatProductionTime($time)
	{
		if ($time < 28800)
		{
			return \Helper\Formatter::time($time);
		}
		else
		{
			$days = round($time / (8 * 3600));

			if ($days == 1) {
				return $days.' '.\SmartWork\Translator::getInstance()->gt('day');
			}

			return $days.' '.\SmartWork\Translator::getInstance()->gt('days');
		}
	}

	/**
	 * Get the talents used in this crafting. As default only unfinished parts will be returned.
	 *
	 * @param boolean $getAll Whether to get all talents or not, defaults to false
	 *
	 * @return array
	 */
	public function getTalents($getAll = false)
	{
		$translator = \SmartWork\Translator::getInstance();
		$calculatedTalentPoints = $this->calculateTalentPoints();
		$talents = array();

		foreach ($this->gainedTalentPoints as $talent => $talentPoints)
		{
			if ($calculatedTalentPoints[$talent] <= $talentPoints && !$getAll)
			{
				continue;
			}

			$talents[$talent] = $translator->gt($talent);
		}

		return $talents;
	}

	/**
	 * Add gained talent points.
	 *
	 * @param integer $talentPoints
	 */
	public function addTalentPoints($talentPoints)
	{
		foreach ($talentPoints as $talent => $points)
		{
			$sql = '
				UPDATE craftingTalentPoints, materialsToBlueprints
				SET craftingTalentPoints.`gainedTalentPoints` = craftingTalentPoints.`gainedTalentPoints` + '.\sqlval($points, false).'
				WHERE craftingTalentPoints.`craftingId` = '.\sqlval($this->craftingId).'
					AND materialsToBlueprints.talent = '.\sqlval($talent).'
					AND materialsToBlueprints.`blueprintId` = craftingTalentPoints.`blueprintId`
					AND materialsToBlueprints.materialId = craftingTalentPoints.materialId
			';
			\query($sql);

			$this->gainedTalentPoints[$talent] += $points;
		}

		$sql = '
			UPDATE craftings
			SET `doneProofs` = `doneProofs` + 1
			WHERE `craftingId` = '.\sqlval($this->craftingId).'
		';
		\query($sql);

		if ($this->checkIfDone())
		{
			$this->done();
		}
	}

	/**
	 * Check whether all needed talent points are reached
	 *
	 * @return boolean
	 */
	public function checkIfDone()
	{
		$gainedTalentPoints = $this->getGainedTalentPoints();
		$talentPoints = $this->calculateTalentPoints();
		$doneTalents = array();

		foreach ($talentPoints as $talent => $points)
		{
			$doneTalents[$talent] = false;

			if ($gainedTalentPoints[$talent] >= $points)
			{
				$doneTalents[$talent] = true;
			}
		}

		return !in_array(false, $doneTalents);
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
