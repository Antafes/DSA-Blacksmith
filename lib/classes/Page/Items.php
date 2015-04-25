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

		$this->getTemplate()->assign('itemsListing', $itemsListing);
		$this->getTemplate()->assign('currencyList', $moneyHelper->getCurrencyList());
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
