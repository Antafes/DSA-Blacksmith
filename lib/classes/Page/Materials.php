<?php
namespace Page;

/**
 * Description of Materials
 *
 * @author Neithan
 */
class Materials extends \Page
{
	public function __construct()
	{
		parent::__construct('materials');
	}

	public function process()
	{
		$this->template->loadJs('addMaterial');

		$materialListing = \Listing\Materials::loadList();
		$materialTypeListing = \Listing\MaterialTypes::loadList();

		if ($_GET['remove'])
		{
			$this->removeMaterial($materialListing->getById($_GET['remove']));
		}

		$money = new \Helper\Money();
		$this->getTemplate()->assign('materialListing', $materialListing);
		$this->getTemplate()->assign('materialTypeListing', $materialTypeListing);
		$this->getTemplate()->assign('currencyList', $money->getCurrencyList());
	}

	/**
	 * @param \Model\Material $material
	 */
	protected function removeMaterial($material)
	{
		$material->remove();
		redirect('index.php?page=Materials');
	}
}