<?php
namespace Model;

/**
 * Description of Techniques
 *
 * @author Neithan
 */
class Technique extends \Model
{
	/**
	 * @var integer
	 */
	protected $techniqueId;

	/**
	 * @var string
	 */
	protected $name;

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
				`techniqueId`,
				`name`,
				`timeFactor`,
				`priceFactor`,
				proof,
				`breakFactor`,
				`hitPoints`,
				`forceModificator`
			FROM techniques
			WHERE `techniqueId` = '.sqlval($id).'
				AND !deleted
		';
		$technique = query($sql);
		$obj = new self();
		$obj->fill($technique);

		return $obj;
	}

	public function getTechniqueId()
	{
		return $this->techniqueId;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getTimeFactor()
	{
		return $this->timeFactor;
	}

	public function getPriceFactor()
	{
		return $this->priceFactor;
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

	public function getForceModificator()
	{
		return json_decode($this->forceModificator, true);
	}

	public static function create($data)
	{
		if (!$data['name'] && !$data['timeFactor'] && !$data['priceFactor'])
			return false;

		$data['timeFactor'] = str_replace(',', '.', $data['timeFactor']);
		$data['priceFactor'] = str_replace(',', '.', $data['priceFactor']);

		if ($data['forceModificator'])
		{
			preg_match_all('/([+-]?\d) ?\/ ?([+-]?\d) ?(\|\||or|oder)?/', $data['forceModificator'], $matches, PREG_SET_ORDER);
			$forceModificators = array();

			foreach ($matches as $match)
			{
				$forceModificators['or'][] = array(
					$match[1],
					$match[2],
				);
			}
		}

		$sql = '
			INSERT INTO techniques
			SET name = '.sqlval($data['name']).',
				timeFactor = '.sqlval($data['timeFactor']).',
				priceFactor = '.sqlval($data['priceFactor']).',
				proof = '.sqlval($data['proof']).',
				breakFactor = '.sqlval($data['breakFactor']).',
				hitPoints = '.sqlval($data['hitPoints']).',
				forceModificator = '.sqlval(json_encode($forceModificators)).'
		';
		query($sql);

		return true;
	}

	public function remove()
	{
		$sql = '
			UPDATE techniques
			SET deleted = 1
			WHERE `techniqueId` = '.sqlval($this->techniqueId).'
		';
		return query($sql);
	}
}
