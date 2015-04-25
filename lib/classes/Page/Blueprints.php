<?php
namespace Page;

/**
 * Description of Plans
 *
 * @author Neithan
 */
class Blueprints extends \SmartWork\Page
{
	public function __construct()
	{
		parent::__construct('blueprints');
	}

	public function process()
	{
		$this->getTemplate()->loadJs('addBlueprint');
		$this->getTemplate()->loadJs('jquery.materialSelect');
		$this->getTemplate()->loadJs('jquery.techniqueSelect');
		$this->getTemplate()->loadJs('jquery.blueprint');
		$this->getTemplate()->loadJs('showBlueprint');

		$blueprintListing = \Listing\Blueprints::loadList();
		$itemListing = \Listing\Items::loadList();
		$itemTypeListing = \Listing\ItemTypes::loadList();
		$materialListing = \Listing\Materials::loadList();
		$techniqueListing = \Listing\Techniques::loadList();
		$moneyHelper = new \Helper\Money();

		if ($_GET['remove'])
		{
			$this->removeBlueprint($blueprintListing->getById($_GET['remove']));
		}

		$this->getTemplate()->assign('blueprintListing', $blueprintListing);
		$this->getTemplate()->assign('itemListing', $itemListing);
		$this->getTemplate()->assign('itemTypeListing', $itemTypeListing);
		$this->getTemplate()->assign('materialListing', $materialListing);
		$this->getTemplate()->assign('materialList', json_encode($materialListing->getAsArray()));
		$this->getTemplate()->assign('techniqueListing', $techniqueListing);
		$this->getTemplate()->assign('techniqueList', json_encode($techniqueListing->getAsArray()));
		$this->getTemplate()->assign('currencyList', $moneyHelper->getCurrencyList());
	}

	/**
	 * @param \Model\Blueprint $blueprint
	 */
	protected function removeBlueprint($blueprint)
	{
		$blueprint->remove();
		redirect('index.php?page=Blueprints');
	}
}
