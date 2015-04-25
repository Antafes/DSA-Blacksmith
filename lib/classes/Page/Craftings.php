<?php
namespace Page;
/**
 * Description of Craftings
 *
 * @author Neithan
 */
class Craftings extends \SmartWork\Page
{
	public function __construct()
	{
		parent::__construct('craftings');
	}

	public function process()
	{
		$this->getTemplate()->loadJs('addCrafting');
		$this->getTemplate()->loadJs('jquery.blueprint');
		$this->getTemplate()->loadJs('showCrafting');
		$this->getTemplate()->loadJs('addTalentPoints');
		$craftingsList = \Listing\Craftings::loadList();

		if ($_GET['remove'])
		{
			$this->removeCrafting($craftingsList->getById($_GET['remove']));
		}

		$this->getTemplate()->assign('blueprints', \Listing\Blueprints::loadList());
		$this->getTemplate()->assign('characters', \Listing\Characters::loadList());
		$this->getTemplate()->assign('craftings', $craftingsList);
	}

	/**
	 * @param \Model\Crafting $crafting
	 */
	protected function removeCrafting($crafting)
	{
		$crafting->remove();
		redirect('index.php?page=Craftings');
	}
}
