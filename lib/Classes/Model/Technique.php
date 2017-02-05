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
 * Model class for the techniques.
 *
 * @package Model
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Technique extends \SmartWork\Model
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
     * Load a technique by the given id.
     *
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

    /**
     * Fill the objects properties with the given data and cast them if possible to the best
     * matching type. Only existing properties are filled.
     *
     * @param array $data
     *
     * @return void
     */
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

    /**
     * Get the technique id.
     *
     * @return integer
     */
    public function getTechniqueId()
    {
        return $this->techniqueId;
    }

    /**
     * Get the technique name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the time factor that this technique adds to the production time.
     *
     * @return float
     */
    public function getTimeFactor()
    {
        return $this->timeFactor;
    }

    /**
     * Get the price factor that this technique adds to the total price.
     *
     * @return float
     */
    public function getPriceFactor()
    {
        return $this->priceFactor;
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
     * Whether other techniques are allowed or not.
     *
     * @return boolean
     */
    public function getNoOtherAllowed()
    {
        return $this->noOtherAllowed;
    }

    /**
     * Whether this technique changes the price of the item to unsellable.
     *
     * @return boolean
     */
    public function getUnsellable()
    {
        return $this->unsellable;
    }

    /**
     * Create a new technique from the given array.
     * array(
     *     'name' => 'test',
     *     'timeFactor' => 1.5,
     *     'priceFactor' => 2.0,
     *     'proof' => 0,
     *     'breakFactor' => 1,
     *     'hitPoints' => 0,
     *     'noOtherAllowed' => 1,
     *     'unsellable' => 0,
     * )
     *
     * @param array $data
     *
     * @return boolean
     */
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
        \query($sql);

        return true;
    }

    /**
     * Update the technique.
     *
     * @param array $data
     *
     * @return integer
     */
    public function update($data)
    {
        $update = '';

        $data['noOtherAllowed'] = $data['noOtherAllowed'] ? $data['noOtherAllowed'] : 0;
        $data['unsellable'] = $data['unsellable'] ? $data['unsellable'] : 0;

        foreach ($data as $key => $value)
        {
            $update .= \sqlval($key, false).' = '.\sqlval($value).",\n";
        }

        $update = substr($update, 0, -2);

        $sql = '
            UPDATE techniques
            SET '.$update.'
            WHERE `techniqueId` = '.\sqlval($this->techniqueId).'
        ';
        $result = \query($sql);

        if ($result)
        {
            $this->fill($data);
        }

        return $result;
    }

    /**
     * Remove this technique.
     *
     * @return void
     */
    public function remove()
    {
        $sql = '
            UPDATE techniques
            SET deleted = 1
            WHERE `techniqueId` = '.\sqlval($this->techniqueId).'
        ';
        \query($sql);
    }

    /**
     * Get the properties of this object as an array.
     *
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
