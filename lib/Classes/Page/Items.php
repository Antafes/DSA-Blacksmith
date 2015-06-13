<?php
/**
 * Part of the dsa blacksmith.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
namespace Page;

/**
 * Class for the items page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Items extends \SmartWork\Page
{
	/**
	 * Set the used template.
	 */
	public function __construct()
	{
		parent::__construct('items');
	}

	/**
	 * Add javascripts, handle removing of items and show the item list.
	 *
	 * @return void
	 */
	public function process()
	{
		$this->template->loadJs('addItem');

		$itemsListing = \Listing\Items::loadList();
		$moneyHelper = new \Helper\Money();

		if ($_GET['remove'])
		{
			$this->removeItem($itemsListing->getById($_GET['remove']));
		}

		$this->assign('itemsListing', $itemsListing);
		$this->assign('currencyList', $moneyHelper->getCurrencyList());
		$this->assign('columsPerItemType', array(
			'meleeWeapon' => array(
				'item' => array(
					'heading' => 'item',
					'key' => 'name',
				),
				'hitPoints' => array(
					'heading' => 'hp',
					'key' => 'hitPointsString',
				),
				'weight' => array(
					'heading' => 'weight',
					'key' => 'weight',
				),
				'breakFactor' => array(
					'heading' => 'bf',
					'key' => 'breakFactor',
				),
				'initiative' => array(
					'heading' => 'ini',
					'key' => 'initiative',
				),
				'price' => array(
					'heading' => 'price',
					'key' => 'priceFormatted',
				),
				'weaponModificator' => array(
					'heading' => 'wm',
					'key' => 'weaponModificatorFormatted',
				),
				'notes' => array(
					'heading' => 'notes',
					'key' => 'notes',
				),
			),
			'rangedWeapon' => array(
				'item' => array(
					'heading' => 'item',
					'key' => 'name',
				),
				'hitPoints' => array(
					'heading' => 'hp',
					'key' => 'hitPointsString',
				),
				'weight' => array(
					'heading' => 'weight',
					'key' => 'weight',
				),
				'physicalStrengthRequirement' => array(
					'heading' => 'physicalStrengthRequirement',
					'key' => 'physicalStrengthRequirement',
				),
				'price' => array(
					'heading' => 'price',
					'key' => 'priceFormatted',
				),
			),
		));
	}

	/**
	 * Remove an item.
	 *
	 * @param \Model\Item $item
	 *
	 * @return void
	 */
	protected function removeItem($item)
	{
		$item->remove();
		redirect('index.php?page=Items');
	}
}
