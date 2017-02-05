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
 * Model class for the blueprints.
 *
 * @package Model
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Blueprint extends \SmartWork\Model
{
    /**
     * @var integer
     */
    protected $blueprintId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Model\Item
     */
    protected $item;

    /**
     * @var \Model\ItemType
     */
    protected $itemType;

    /**
     * @var \Model\Item
     */
    protected $projectileForItem = null;

    /**
     * @var string
     */
    protected $damageType;

    /**
     * @var string
     */
    protected $materialWeaponModificator;

    /**
     * @var integer
     */
    protected $upgradeHitPoints;

    /**
     * @var integer
     */
    protected $upgradeBreakFactor;

    /**
     * @var integer
     */
    protected $upgradeInitiative;

    /**
     * @var string
     */
    protected $upgradeWeaponModificator;

    /**
     * @var array
     */
    protected $materialList;

    /**
     * @var array
     */
    protected $techniqueList;

    /**
     * @var integer
     */
    protected $bonusRangedFightValue;

    /**
     * @var integer
     */
    protected $reducePhysicalStrengthRequirement;

    /**
     * Load the blueprint for the given id.
     *
     * @param integer $id
     *
     * @return \self
     */
    public static function loadById($id)
    {
        $sql = '
            SELECT
                `blueprintId`,
                `name`,
                `itemId`,
                `itemTypeId`,
                `projectileForItemId`,
                `damageType`,
                `materialWeaponModificator`,
                `upgradeHitPoints`,
                `upgradeBreakFactor`,
                `upgradeInitiative`,
                `upgradeWeaponModificator`,
                `bonusRangedFightValue`,
                `reducePhysicalStrengthRequirement`
            FROM blueprints
            WHERE `blueprintId` = '.\sqlval($id).'
                AND !`deleted`
        ';
        $blueprint = query($sql);
        $obj = new self();
        $obj->fill($blueprint);
        $obj->loadMaterials();
        $obj->loadTechniques();

        return $obj;
    }

    /**
     * Create a new blueprint from the given array.
     * array(
     *     'name' => 'test',
     *     'userId' => 1,
     *     'itemId' => 1,
     *     'itemTypeId => 1,
     *     'damageType' => 'damage',
     *     'material' => array(
     *         0 => 1,
     *     ),
     *     'percentage' => array(
     *         0 => 100
     *     ),
     *     'materialWeaponModificator' => '0/0',
     *     'technique' => array(
     *         0 => 1,
     *     )
     *     'upgradeHitPoints' => 0,
     *     'upgradeBreakFactor' => 0,
     *     'upgradeInitiative' => 0,
     *     'upgradeWeaponModificator' => '0/0',
     * )
     *
     * @param array $data
     *
     * @return boolean
     */
    public static function create($data)
    {
        if (!$data['name'] && !$data['itemId'] && count($data['material']) === 0)
        {
            return false;
        }

        $weaponModificatorString = '';

        if (!empty($data['materialWeaponModificator']))
        {
            foreach ($data['materialWeaponModificator'] as $materialWeaponModificator)
            {
                $weaponModificatorString .= $materialWeaponModificator . ' || ';
            }
        }

        $weaponModificators = \Helper\WeaponModificator::getWeaponModificatorArray(substr($weaponModificatorString, 0, -2));
        $upgradeWeaponModificator = \Helper\WeaponModificator::toWeaponModificatorArray($data['upgradeWeaponModificator']['attack'], $data['upgradeWeaponModificator']['parade']);
        $projectileForItem = Item::loadById($data['projectileForItemId']);

        $sql = '
            INSERT INTO blueprints
            SET name = '.\sqlval($data['name']).',
                userId = '.\sqlval($data['userId']).',
                itemId = '.\sqlval($data['itemId']).',
                itemTypeId = '.\sqlval($data['itemTypeId']).',
                `projectileForItemId` = '.\sqlval($projectileForItem->getItemId()).',
                damageType = '.\sqlval($data['damageType']).',
                materialWeaponModificator = '.\sqlval(json_encode($weaponModificators)).',
                upgradeHitPoints = '.\sqlval($data['upgradeHitPoints']).',
                upgradeBreakFactor = '.\sqlval($data['upgradeBreakFactor']).',
                upgradeInitiative = '.\sqlval($data['upgradeInitiative']).',
                upgradeWeaponModificator = '.\sqlval(json_encode($upgradeWeaponModificator)).',
                bonusRangedFightValue = '.\sqlval($data['bonusRangedFightValue']).',
                reducePhysicalStrengthRequirement = '.\sqlval($data['reducePhysicalStrengthRequirement']).'
        ';
        $blueprintId = query($sql);

        foreach ($data['material'] as $key => $material)
        {
            $materialAssetId = false;
            $sql = '
                SELECT
                    `materialAssetId`,
                    `percentage`
                FROM materialAssets
                WHERE `materialId` = '.\sqlval($material).'
                    AND !deleted
                ORDER BY percentage DESC
            ';
            $materialAssets = \query($sql, true);

            foreach ($materialAssets as $materialAsset)
            {
                if ($data['percentage'][$key] >= $materialAsset['percentage'])
                {
                    $materialAssetId = $materialAsset['materialAssetId'];
                    break;
                }
            }

            if (empty($materialAssetId))
            {
                $materialAssetId = $materialAssets[0]['materialAssetId'];
            }

            $sql = '
                INSERT INTO materialsToBlueprints
                SET materialId = '.\sqlval($material).',
                    blueprintId = '.\sqlval($blueprintId).',
                    materialAssetId = '.\sqlval($materialAssetId).',
                    percentage = '.\sqlval($data['percentage'][$key]).',
                    talent = '.\sqlval($data['talent'][$key]).'
            ';
            query($sql);
        }

        if (!empty($data['technique']))
        {
            foreach ($data['technique'] as $technique)
            {
                $sql = '
                    INSERT INTO techniquesToBlueprints
                    SET techniqueId = '.\sqlval($technique).',
                        blueprintId = '.\sqlval($blueprintId).'
                ';
                query($sql);
            }
        }

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
            if ($key === 'itemId')
            {
                $this->item = Item::loadById($value);
            }
            elseif ($key === 'itemTypeId')
            {
                $this->itemType = ItemType::loadById($value);
            }
            elseif ($key === 'projectileForItemId' && $value)
            {
                $this->projectileForItem = Item::loadById($value);
            }
            elseif (property_exists($this, $key))
            {
                $this->$key = $this->castToType($value);
            }
        }
    }

    /**
     * Load the materials for the blueprint.
     *
     * @return void
     */
    public function loadMaterials()
    {
        $sql = '
            SELECT
                `materialId`,
                `materialAssetId`,
                percentage,
                talent
            FROM materialsToBlueprints
            WHERE `blueprintId` = '.\sqlval($this->blueprintId).'
                AND !deleted
        ';
        $materialIds = query($sql, true);

        $list = array();
        foreach ($materialIds as $material)
        {
            $list[$material['materialId']] = array(
                'material' => \Model\Material::loadById($material['materialId']),
                'materialAsset' => \Model\MaterialAsset::loadById($material['materialAssetId']),
                'percentage' => intval($material['percentage']),
                'talent' => $material['talent'],
            );
        }

        $this->materialList = $list;
    }

    /**
     * Load the techniques for the blueprint.
     *
     * @return void
     */
    public function loadTechniques()
    {
        $sql = '
            SELECT `techniqueId`
            FROM techniquesToBlueprints
            WHERE `blueprintId` = '.\sqlval($this->blueprintId).'
                AND !deleted
        ';
        $techniqueIds = query($sql, true);

        $list = array();
        if (!empty($techniqueIds))
        {
            foreach ($techniqueIds as $technique)
            {
                $list[$technique['techniqueId']] = \Model\Technique::loadById($technique['techniqueId']);
            }
        }

        $this->techniqueList = $list;
    }

    /**
     * Get the id of the blueprint.
     *
     * @return integer
     */
    public function getBlueprintId()
    {
        return $this->blueprintId;
    }

    /**
     * Get the name of the blueprint.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the item which the blueprint is based on.
     *
     * @return \Model\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Get the item type of the blueprint.
     *
     * @return \Model\ItemType
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * Get the item the projectile is made for.
     * Only used for projectiles.
     *
     * @return \Model\Item|null
     */
    function getProjectileForItem()
    {
        return $this->projectileForItem;
    }

    /**
     * Get the damage type, may be damage or stamina.
     *
     * @return string
     */
    public function getDamageType()
    {
        return $this->damageType;
    }

    /**
     * Get the material weapon modificator as an array.
     *
     * @return array
     */
    public function getMaterialWeaponModificator()
    {
        return json_decode($this->materialWeaponModificator, true);
    }

    /**
     * Get the upgrad hit points value.
     *
     * @return integer
     */
    public function getUpgradeHitPoints()
    {
        return $this->upgradeHitPoints;
    }

    /**
     * Get the upgrade break factor value.
     *
     * @return integer
     */
    public function getUpgradeBreakFactor()
    {
        return $this->upgradeBreakFactor;
    }

    /**
     * Get the upgrade initiative value.
     *
     * @return integer
     */
    public function getUpgradeInitiative()
    {
        return $this->upgradeInitiative;
    }

    /**
     * Get the upgrade weapon modificator values.
     *
     * @return array
     */
    public function getUpgradeWeaponModificator()
    {
        return json_decode($this->upgradeWeaponModificator, true);
    }

    /**
     * Get the material list.
     *
     * array(
     *     array(
     *         'material' => \Model\Material,
     *         'materialAsset' => \Model\MaterialAsset,
     *         'percentage' => 100,
     *         'talent' => 'blacksmith', // may be one of 'bowMaking', 'precisionMechanics',
     *                                      'blacksmith', 'woodworking', 'leatherworking',
     *                                      'tailoring'
     *     )
     * )
     *
     * @return array
     */
    public function getMaterialList()
    {
        return $this->materialList;
    }

    /**
     * Get the techniques list.
     *
     * @return array
     */
    public function getTechniqueList()
    {
        return $this->techniqueList;
    }

    /**
     * The bonus for the ranged fight value.
     * Only used for ranged weapons.
     *
     * @return integer
     */
    public function getBonusRangedFightValue()
    {
        return $this->bonusRangedFightValue;
    }

    /**
     * The reducement for the physical strength requirement.
     * Only used for ranged weapons.
     *
     * @return integer
     */
    public function getReducePhysicalStrengthRequirement()
    {
        return $this->reducePhysicalStrengthRequirement;
    }

    /**
     * Calculate the end price for the blueprint.
     *
     * @return string
     */
    public function getEndPrice()
    {
        $price = $this->getItem()->getPrice();
        $materialPrice = 0;
        $priceFactor = 0;
        $priceFactorBelowOne = 0;
        $moneyHelper = new \Helper\Money();

        switch ($this->getItemType()->getType()) {
            case 'meleeWeapon':
                foreach ($this->materialList as $item)
                {
                    /* @var $material \Model\Material */
                    $material = $item['material'];
                    /* @var $materialAsset \Model\MaterialAsset */
                    $materialAsset = $item['materialAsset'];

                    if ($materialAsset->getPriceFactor())
                    {
                        if ($materialAsset->getPriceFactor() >= 1)
                        {
                            $priceFactor += $materialAsset->getPriceFactor();
                        }
                        else
                        {
                            if (!$priceFactorBelowOne)
                            {
                                $priceFactorBelowOne = $materialAsset->getPriceFactor();
                            }
                            else
                            {
                                $priceFactorBelowOne *= $materialAsset->getPriceFactor();
                            }
                        }
                    }
                    elseif ($materialAsset->getPriceWeight())
                    {
                        $materialPrice += ($this->item->getWeight() * ($item['percentage'] / 100)) * $materialAsset->getPriceWeightRaw();
                    }
                }

                /* @var $technique \Model\Technique */
                foreach ($this->techniqueList as $technique)
                {
                    if ($technique->getUnsellable())
                    {
                        $translator = \SmartWork\Translator::getInstance();
                        return $translator->gt('unsellable');
                    }

                    if ($technique->getPriceFactor() >= 1)
                    {
                        $priceFactor += $technique->getPriceFactor();
                    }
                    else
                    {
                        if (!$priceFactorBelowOne)
                        {
                            $priceFactorBelowOne = $technique->getPriceFactor();
                        }
                        else
                        {
                            $priceFactorBelowOne *= $technique->getPriceFactor();
                        }
                    }
                }

                $priceFactor += $this->getUpgradeHitPoints() * 3;
                $priceFactor += $this->getUpgradeBreakFactor() * -2;
                $priceFactor += $this->getUpgradeInitiative() * 5;

                if ($this->getUpgradeWeaponModificator())
                {
                    $upgradeWeaponModificator = $this->getUpgradeWeaponModificator();

                    $priceFactor += ($upgradeWeaponModificator[0]['attack'] + $upgradeWeaponModificator[0]['parade']) * 5;
                }
                break;
            case 'rangedWeapon':
                foreach ($this->materialList as $item)
                {
                    /* @var $material \Model\Material */
                    $material = $item['material'];
                    /* @var $materialAsset \Model\MaterialAsset */
                    $materialAsset = $item['materialAsset'];

                    if ($materialAsset->getPriceFactor())
                    {
                        if ($materialAsset->getPriceFactor() >= 1)
                        {
                            $priceFactor += $materialAsset->getPriceFactor();
                        }
                        else
                        {
                            if (!$priceFactorBelowOne)
                            {
                                $priceFactorBelowOne = $materialAsset->getPriceFactor();
                            }
                            else
                            {
                                $priceFactorBelowOne *= $materialAsset->getPriceFactor();
                            }
                        }
                    }
                    elseif ($materialAsset->getPriceWeight())
                    {
                        $materialPrice += ($this->item->getWeight() * ($item['percentage'] / 100)) * $materialAsset->getPriceWeightRaw();
                    }
                }

                $priceFactor += $this->getBonusRangedFightValue() * 5;
                $priceFactor += $this->getReducePhysicalStrengthRequirement() * 3;
                break;
            case 'shield':
                break;
            case 'armor':
                break;
            case 'projectile':
                break;
        }

        if ($priceFactor > 0)
        {
            $price *= $priceFactor;
        }

        if ($priceFactorBelowOne > 0)
        {
            $price *= $priceFactorBelowOne;
        }

        $price += $materialPrice;

        return number_format($moneyHelper->exchange($price, 'K', 'S'), 0, ',', '.') . ' S';
    }

    /**
     * Get the time units for each proof.
     *
     * @return integer
     */
    public function getTimeUnits()
    {
        $time = $this->getItemType()->getTime();

        foreach ($this->getMaterialList() as $item)
        {
            $materialAssetList = $item['material']->getMaterialAssetListing()->getList();
            krsort($materialAssetList);

            /* @var $materialAsset \Model\MaterialAsset */
            foreach ($materialAssetList as $materialAsset)
            {
                $time *= $materialAsset->getTimeFactor();
            }
        }

        /* @var $technique \Model\Technique */
        foreach ($this->getTechniqueList() as $technique)
        {
            $time *= $technique->getTimeFactor();
        }

        return $time;
    }

    /**
     * Get the resulting stats for the blueprint.
     *
     * @return array
     */
    public function getResultingStats()
    {
        $translator = \SmartWork\Translator::getInstance();

        $breakFactor = $this->item->getBreakFactor();
        $initiative = $this->item->getInitiative();
        $weaponModificatorList = array_merge(
            $this->getMaterialWeaponModificator(),
            $this->getUpgradeWeaponModificator()
        );

        foreach ($this->getMaterialList() as $item)
        {
            /* @var $material \Model\Material */
            $material = $item['material'];
            $materialAssetList = $material->getMaterialAssetListing()->getList();
            usort($materialAssetList, array(__CLASS__, 'compareMaterialAssetsPercentage'));

            /* @var $materialAsset \Model\MaterialAsset */
            foreach ($materialAssetList as $materialAsset)
            {
                if ($materialAsset->getPercentage() > $item['percentage'])
                {
                    continue;
                }

                $breakFactor += $materialAsset->getBreakFactor();
                break;
            }
        }

        /* @var $technique \Model\Technique */
        foreach ($this->getTechniqueList() as $technique)
        {
            $breakFactor += $technique->getBreakFactor();
        }

        $weaponModificator = array_pop($this->item->getWeaponModificator());

        foreach ($weaponModificatorList as $weaponMod)
        {
            $weaponModificator['attack'] += $weaponMod['attack'];
            $weaponModificator['parade'] += $weaponMod['parade'];
        }

        $hitPoints = $this->getEndHitPoints();
        $initiative += $this->getUpgradeInitiative();
        $breakFactor += $this->getUpgradeBreakFactor();
        $damageType = 'damage';

        if ($this->item->getDamageType() == 'stamina' || $this->getDamageType() == 'stamina')
        {
            $damageType = 'stamina';
        }

        if ($this->getItem()->getItemType() === 'projectile')
        {
            $formatedTime = number_format(
                $this->getTimeUnits(), 2, $translator->gt('decimalPoint'), $translator->gt('thousandsSeparator')
            );
        }
        else
        {
            $formatedTime = number_format($this->getTimeUnits(), 0);
        }

        return array(
            'name' => $this->getName().' ('.$this->item->getName().')',
            'type' => $this->getItemType()->getType(),
            'projectileForItem' => $this->getProjectileForItem() ? $this->getProjectileForItem()->getName() : '',
            'hitPoints' => \Helper\HitPoints::getHitPointsString(array(
                'hitPointsDice' => $hitPoints['dices'],
                'hitPointsDiceType' => $hitPoints['diceType'],
                'hitPoints' => $hitPoints['add'] + $hitPoints['material'],
                'damageType' => $damageType,
            )),
            'weight' => $this->item->getWeight(),
            'breakFactor' => $breakFactor,
            'initiative' => $initiative,
            'price' => $this->getEndPrice(),
            'weaponModificator' => \Helper\WeaponModificator::format($weaponModificator),
            'notes' => $this->getNotes(),
            'time' => $formatedTime.' '.$translator->gt('tu'),
        );
    }

    /**
     * Remove the blueprint.
     *
     * @return void
     */
    public function remove()
    {
        $sql = '
            UPDATE materialstoblueprints
            SET deleted = 1
            WHERE `blueprintId` = '.\sqlval($this->blueprintId).'
        ';
        \query($sql);
        $sql = '
            UPDATE techniquestoblueprints
            SET deleted = 1
            WHERE `blueprintId` = '.\sqlval($this->blueprintId).'
        ';
        \query($sql);
        $sql = '
            UPDATE blueprints
            SET deleted = 1
            WHERE `blueprintId` = '.\sqlval($this->blueprintId).'
        ';
        \query($sql);
    }

    /**
     * Get the blueprint as array.
     *
     * @return array
     */
    public function getAsArray()
    {
        $upgradeWeaponModificator = $this->getUpgradeWeaponModificator();
        return array(
            'id' => $this->getBlueprintId(),
            'name' => $this->getName(),
            'item' => $this->getItem(),
            'itemType' => $this->getItemType(),
            'projectileForItem' => $this->getProjectileForItem(),
            'damageType' => $this->getDamageType(),
            'materials' => $this->getMaterialsString(),
            'techniques' => $this->getTechniquesString(),
            'materialWeaponModificator' => $this->getMaterialWeaponModificator(),
            'upgradeHitPoints' => $this->getUpgradeHitPoints(),
            'upgradeBreakFactor' => $this->getUpgradeBreakFactor(),
            'upgradeInitiative' => $this->getUpgradeInitiative(),
            'upgradeWeaponModificator' => \Helper\WeaponModificator::format($upgradeWeaponModificator[0]),
            'bonusRangedFightValue' => $this->getBonusRangedFightValue(),
            'reducePhysicalStrengthRequirement' => $this->getReducePhysicalStrengthRequirement(),
        );
    }

    /**
     * Get the end hit points consisting of the item hit points, the upgrade hit points, the
     * material hit points and the technique hit points.
     *
     * @return array
     */
    public function getEndHitPoints()
    {
        $data = array(
            'dices' => $this->item->getHitPointsDice(),
            'diceType' => $this->item->getHitPointsDiceType(),
            'add' => $this->item->getHitPoints() + $this->getUpgradeHitPoints(),
            'material' => 0,
        );

        /* @var $technique \Model\Technique */
        foreach ($this->getTechniqueList() as $technique)
        {
            $data['material'] += $technique->getHitPoints();
        }

        foreach ($this->getMaterialList() as $item)
        {
            /* @var $material \Model\Material */
            $material = $item['material'];
            $materialAssetList = $material->getMaterialAssetListing()->getList();
            usort($materialAssetList, array(__CLASS__, 'compareMaterialAssetsPercentage'));

            /* @var $materialAsset \Model\MaterialAsset */
            foreach ($materialAssetList as $materialAsset)
            {
                if ($materialAsset->getPercentage() > $item['percentage'])
                {
                    continue;
                }

                $data['material'] += $materialAsset->getHitPoints();
                break;
            }
        }

        return $data;
    }

    /**
     * Compare method for sorting the material assets along their percentages
     *
     * @param \Model\MaterialAsset $a
     * @param \Model\MaterialAsset $b
     *
     * @return int
     */
    public static function compareMaterialAssetsPercentage($a, $b)
    {
        if ($a->getPercentage() == $b->getPercentage())
        {
            return 0;
        }

        return ($a->getPercentage() < $b->getPercentage()) ? +1 : -1;
    }

    /**
     * Get the item and blueprint notes.
     *
     * @return string
     */
    protected function getNotes()
    {
        $notes = $this->item->getNotes();
        $translator = \SmartWork\Translator::getInstance();

        if ($this->bonusRangedFightValue)
        {
            if (!empty($notes)) {
                $notes .= ' ';
            }

            $notes .= $translator->gt('bonusRangedFightValueNote').'('.$this->bonusRangedFightValue.')';
        }

        if ($this->reducePhysicalStrengthRequirement)
        {
            if (!empty($notes)) {
                $notes .= ' ';
            }

            $notes .= $translator->gt('reducePhysicalStrengthRequirementNote');
        }

        return $notes;
    }

    /**
     * Get the materials of this blueprint as a string.
     *
     * @return string
     */
    protected function getMaterialsString()
    {
        $materials = '';

        foreach ($this->getMaterialList() as $entry)
        {
            /* @var $material \Model\Material */
            $material = $entry['material'];
            $materials .= '<span title="'.$entry['percentage'].'%">'.$material->getName().'</span><br>';
        }

        return $materials;
    }

    /**
     * Get the techniques of this blueprint as a string.
     *
     * @return string
     */
    protected function getTechniquesString()
    {
        $techniques = '';

        /* @var $technique \Model\Technique */
        foreach ($this->getTechniqueList() as $technique)
        {
            $techniques .= $technique->getName().'<br>';
        }

        return $techniques;
    }
}
