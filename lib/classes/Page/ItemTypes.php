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
 * Class for the item types page.
 *
 * @package Page
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class ItemTypes extends \SmartWork\Page
{
	/**
	 * Set the used template.
	 */
	public function __construct()
	{
		parent::__construct('itemTypes');
	}

	/**
	 * Add javascripts, handle removing if item types and show the list of them.
	 *
	 * @return void
	 */
	public function process()
	{
		$this->template->loadJs('addItemType');

		$itemTypesListing = \Listing\ItemTypes::loadList();

		if ($_GET['remove'])
		{
			$this->removeItemType($itemTypesListing->getById($_GET['remove']));
		}

		$this->getTemplate()->assign('itemTypeListing', $itemTypesListing);
	}

	/**
	 * Remove an item type.
	 *
	 * @param \Model\ItemType $itemType
	 *
	 * @return void
	 */
	protected function removeItemType($itemType)
	{
		$itemType->remove();
		redirect('index.php?page=ItemTypes');
	}
}
