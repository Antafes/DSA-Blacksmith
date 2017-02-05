<?php
/**
 * Part of the dsa blacksmith.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
namespace Listing;

/**
 * List class for the material assets.
 *
 * @package Listing
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class MaterialAssets extends \SmartWork\Listing
{
    /**
     * Load all available material assets.
     *
     * @return \self
     */
    public static function loadList()
    {
        $sql = '
            SELECT `materialAssetId`
            FROM materialAssets
            WHERE !deleted
        ';
        $materialAssetIds = query($sql, true);
        $obj = new self();

        if (empty($materialAssetIds))
        {
            return $obj;
        }

        $list = array();
        foreach ($materialAssetIds as $materialAsset)
        {
            $list[$materialAsset['materialAssetId']] = \Model\MaterialAsset::loadById($materialAsset['materialAssetId']);
        }

        $obj->setList($list);

        return $obj;
    }

    /**
     * Load all assets for the given material.
     *
     * @param integer $materialId
     *
     * @return \self
     */
    public static function loadListMaterial($materialId)
    {
        $sql = '
            SELECT `materialAssetId`
            FROM materialAssets
            WHERE `materialId` = '.\sqlval($materialId).'
                AND !deleted
            ORDER BY percentage
        ';
        $materialAssetIds = query($sql, true);
        $obj = new self();

        if (empty($materialAssetIds))
        {
            return $obj;
        }

        $list = array();
        foreach ($materialAssetIds as $materialAsset)
        {
            $list[$materialAsset['materialAssetId']] = \Model\MaterialAsset::loadById($materialAsset['materialAssetId']);
        }

        $obj->setList($list);

        return $obj;
    }

    /**
     * Get a single material asset by the given id.
     *
     * @param integer $id
     *
     * @return \Model\MaterialAsset
     */
    public function getById($id)
    {
        return $this->list[$id];
    }
}
