<?php
namespace Page;

/**
 * Description of ItemTypes
 *
 * @author Neithan
 */
class ItemTypes extends \SmartWork\Page
{
	public function __construct()
	{
		parent::__construct('itemTypes');
	}

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
	 * @param \Model\ItemType $itemType
	 */
	protected function removeItemType($itemType)
	{
		$itemType->remove();
		redirect('index.php?page=ItemTypes');
	}
}
