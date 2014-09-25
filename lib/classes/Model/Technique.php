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
	 * @var boolean
	 */
	protected $noOtherAllowed;

	/**
	 * @var boolean
	 */
	protected $unsellable;

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
				`noOtherAllowed`,
				unsellable
			FROM techniques
			WHERE `techniqueId` = '.\sqlval($id).'
				AND !deleted
		';
		$technique = query($sql);
		$obj = new self();
		$obj->fill($technique);

		return $obj;
	}

	public function fill($data)
	{
		foreach ($data as $key => $value)
		{
			if ($key === 'noOtherAllowed' || $key === 'unsellable')
			{
				$this->$key = (bool) $value;
			}
			elseif (property_exists($this, $key))
			{
				$this->$key = $this->castToType($value);
			}
		}
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

	public function getNoOtherAllowed()
	{
		return $this->noOtherAllowed;
	}

	public function getUnsellable()
	{
		return $this->unsellable;
	}

	public static function create($data)
	{
		if (!$data['name'] && !$data['timeFactor'] && !$data['priceFactor'])
			return false;

		$data['timeFactor'] = str_replace(',', '.', $data['timeFactor']);
		$data['priceFactor'] = str_replace(',', '.', $data['priceFactor']);

		$sql = '
			INSERT INTO techniques
			SET name = '.\sqlval($data['name']).',
				timeFactor = '.\sqlval($data['timeFactor']).',
				priceFactor = '.\sqlval($data['priceFactor']).',
				proof = '.\sqlval($data['proof']).',
				breakFactor = '.\sqlval($data['breakFactor']).',
				hitPoints = '.\sqlval($data['hitPoints']).',
				noOtherAllowed = '.\sqlval(intval($data['noOtherAllowed'])).',
				unsellable = '.\sqlval(intval($data['unsellable'])).'
		';
		query($sql);

		return true;
	}

	public function remove()
	{
		$sql = '
			UPDATE techniques
			SET deleted = 1
			WHERE `techniqueId` = '.\sqlval($this->techniqueId).'
		';
		return query($sql);
	}

	/**
	 * @return array
	 */
	public function getAsArray()
	{
		return array(
			'id' => $this->getTechniqueId(),
			'name' => $this->getName(),
			'timeFactor' => $this->getTimeFactor(),
			'priceFactor' => $this->getPriceFactor(),
			'proof' => $this->getProof(),
			'breakFactor' => $this->getBreakFactor(),
			'hitPoints' => $this->getHitPoints(),
			'noOtherAllowed' => $this->getNoOtherAllowed(),
			'unsellable' => $this->getUnsellable(),
		);
	}
}
