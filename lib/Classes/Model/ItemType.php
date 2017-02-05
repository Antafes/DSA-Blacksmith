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
 * Model class for item types.
 *
 * @package Model
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class ItemType extends \SmartWork\Model
{
    /**
     * @var integer
     */
    protected $itemTypeId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var integer
     */
    protected $talentPoints;

    /**
     * @var float
     */
    protected $time;

    /**
     * To string method, returns the name of the item type.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Load an item type by its id.
     *
     * @param integer $id
     *
     * @return \self
     */
    public static function loadById($id)
    {
        $sql = '
            SELECT
                `itemTypeId`,
                `name`,
                `type`,
                `talentPoints`,
                `time`
            FROM itemTypes
            WHERE `itemTypeId` = '.\sqlval($id).'
                AND !deleted
        ';
        $itemType = query($sql);
        $obj = new self();

        $obj->fill($itemType);

        return $obj;
    }

    /**
     * Create a new item type from the given array.
     * array(
     *     'name' => 'test',
     *     'talentPoints' => 3,
     *     'time' => 6,
     * )
     *
     * @param array $data
     *
     * @return boolean
     */
    public static function create($data)
    {
        if (!$data['name'] && !$data['talentPoints'] && !$data['time'])
            return false;

        $data['time'] = str_replace(',', '.', $data['time']);

        $sql = '
            INSERT INTO itemTypes
            SET name = '.\sqlval($data['name']).',
                type = '.\sqlval($data['type']).',
                talentPoints = '.\sqlval($data['talentPoints']).',
                time = '.\sqlval($data['time']).'
        ';
        query($sql);

        return true;
    }

    /**
     * Update the current item type.
     *
     * @param array $data
     *
     * @return integer
     */
    public function update($data)
    {
        $update = '';

        foreach ($data as $key => $value)
        {
            $update .= \sqlval($key, false).' = '.\sqlval($value).",\n";
        }

        $update = substr($update, 0, -2);

        $sql = '
            UPDATE itemtypes
            SET '.$update.'
            WHERE `itemTypeId` = '.\sqlval($this->itemTypeId).'
        ';
        $result = \query($sql);

        if ($result)
        {
            $this->fill($data);
        }

        return $result;
    }

    /**
     * Get the item type id.
     *
     * @return integer
     */
    public function getItemTypeId()
    {
        return $this->itemTypeId;
    }

    /**
     * Get the name of the item type.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the general type. May be on of: meleeWeapon, rangedWeapon, shield, armor, projectile
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the talent points modificator.
     *
     * @return integer
     */
    public function getTalentPoints()
    {
        return $this->talentPoints;
    }

    /**
     * Get the modificator for the time units.
     *
     * @return float
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Remove the item type.
     *
     * @return void
     */
    public function remove()
    {
        $sql = '
            UPDATE itemTypes
            SET deleted = 1
            WHERE `itemTypeId` = '.\sqlval($this->itemTypeId).'
        ';
        \query($sql);
    }

    /**
     * Get the item types properties as an array.
     *
     * @return array
     */
    public function getAsArray()
    {
        return array(
            'itemTypeId' => $this->getItemTypeId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'talentPoints' => $this->getTalentPoints(),
            'time' => $this->getTime(),
        );
    }
}
