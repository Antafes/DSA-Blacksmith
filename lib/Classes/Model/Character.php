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
 * Model class for characters.
 *
 * @package Model
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
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
     * Load a character by the given id.
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
     * Get the blueprint as array.
     *
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
     * Create a new character from the given array.
     * array(
     *     'user' => a user object,
     *     'key' => '1409495635389',
     *     'lastUpdate' => datetime object,
     *     'name' => 'test',
     *     'bowMaking' => 4,
     *     'precisionMechanics' => 2,
     *     'blacksmith' => 4,
     *     'woodworking' => 3,
     *     'leatherworking' => 4,
     *     'tailoring' => 4,
     * )
     *
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

    /**
     * Remove the current character.
     *
     * @return void
     */
    public function remove()
    {
        $sql = '
            UPDATE characters
            SET deleted = 1
            WHERE `characterId` = '.sqlval($this->characterId).'
        ';
        query($sql);
    }

    /**
     * The characters id.
     *
     * @return integer
     */
    public function getCharacterId()
    {
        return $this->characterId;
    }

    /**
     * The Helden Software character key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get the last time the character was updated in the Helden Software.
     *
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Get the name of the character.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the bow making talent value.
     *
     * @return integer
     */
    public function getBowMaking()
    {
        return $this->bowMaking;
    }

    /**
     * Get the precision mechanics talent value.
     *
     * @return integer
     */
    public function getPrecisionMechanics()
    {
        return $this->precisionMechanics;
    }

    /**
     * Get the blacksmith talent value.
     *
     * @return integer
     */
    public function getBlacksmith()
    {
        return $this->blacksmith;
    }

    /**
     * Get the woodworking talent value.
     *
     * @return integer
     */
    public function getWoodworking()
    {
        return $this->woodworking;
    }

    /**
     * Get the leatherworking talent value.
     *
     * @return integer
     */
    public function getLeatherworking()
    {
        return $this->leatherworking;
    }

    /**
     * Get the tailoring talent value.
     *
     * @return integer
     */
    public function getTailoring()
    {
        return $this->tailoring;
    }
}
