<?php
namespace Page;

/**
 * Description of Items
 *
 * @author Neithan
 */
class Items extends \SmartWork\Page
{
	public function __construct()
	{
		parent::__construct('items');
	}

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
	 * @param \Model\Item $item
	 */
	protected function removeItem($item)
	{
		$item->remove();
		redirect('index.php?page=Items');
	}
}
