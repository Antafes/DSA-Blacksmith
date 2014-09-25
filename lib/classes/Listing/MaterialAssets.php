<?php
namespace Listing;

/**
 * Description of MaterialAssets
 *
 * @author Neithan
 */
class MaterialAssets extends \Listing
{
	/**
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
	 * @param integer $materialId
	 *
	 * @return \self
	 */
	public static function loadListMaterial($materialId)
	{
		$sql = '
			SELECT `materialAssetId`
			FROM materialAssets
			WHERE `materialId` = '.sqlval($materialId).'
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
	 * @param integer $id
	 *
	 * @return \Model\MaterialAsset
	 */
	public function getById($id)
	{
		return $this->list[$id];
	}
}
